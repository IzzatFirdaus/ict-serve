@echo off
setlocal EnableDelayedExpansion

REM =============================================================================
REM Laravel Quality Assurance Script (qa.bat)
REM =============================================================================
REM Windows batch version of the comprehensive Laravel QA script
REM This script serves as a single-point-of-truth for all local quality checks
REM and is designed to be usable in CI/CD pipelines.
REM
REM Author: Senior DevOps Engineer
REM Version: 1.0.0
REM Compatible: Laravel 12+, PHP 8.2+, Node.js, Windows
REM =============================================================================

REM Configuration
set "PROJECT_ROOT=%~dp0"
set "VENDOR_DIR=%PROJECT_ROOT%vendor"
set "NODE_MODULES_DIR=%PROJECT_ROOT%node_modules"
set "QA_RESULTS_DIR=%PROJECT_ROOT%qa-results"

REM Color codes for output (Windows Command Prompt)
set "RED=[91m"
set "GREEN=[92m"
set "YELLOW=[93m"
set "BLUE=[94m"
set "PURPLE=[95m"
set "CYAN=[96m"
set "NC=[0m"

REM Exit codes
set EXIT_SUCCESS=0
set EXIT_DEPENDENCY_ERROR=1
set EXIT_TOOL_ERROR=2
set EXIT_SETUP_ERROR=3

goto :main

REM =============================================================================
REM Utility Functions
REM =============================================================================

:log_info
echo %CYAN%[%date% %time%] i  %~1%NC%
goto :eof

:log_success
echo %GREEN%[%date% %time%] ✓  %~1%NC%
goto :eof

:log_warning
echo %YELLOW%[%date% %time%] !  %~1%NC%
goto :eof

:log_error
echo %RED%[%date% %time%] ✗  %~1%NC%
goto :eof

:log_step
echo.
echo %CYAN%[%date% %time%] ====  %~1%NC%
echo ========================================
goto :eof

:check_command
where %1 >nul 2>&1
if !errorlevel! neq 0 (
    call :log_error "%1 is not installed or not in PATH"
    exit /b %EXIT_DEPENDENCY_ERROR%
)
goto :eof

:run_command
set "DESCRIPTION=%~1"
set "COMMAND=%~2"
call :log_info "!DESCRIPTION!"
!COMMAND!
if !errorlevel! neq 0 (
    call :log_error "!DESCRIPTION! failed with exit code !errorlevel!"
    exit /b !errorlevel!
) else (
    call :log_success "!DESCRIPTION! completed successfully"
)
goto :eof

REM =============================================================================
REM Dependency Management
REM =============================================================================

:ensure_php_dependencies
call :log_step "Checking PHP Dependencies"

call :check_command composer
if !errorlevel! neq 0 goto :eof

if not exist "%VENDOR_DIR%\autoload.php" (
    call :log_warning "Vendor directory missing or empty. Installing Composer dependencies..."
    call :run_command "Installing Composer dependencies" "composer install --no-interaction --prefer-dist --optimize-autoloader"
) else (
    call :log_success "Composer dependencies are already installed"
)

REM Verify PHP version
for /f "tokens=*" %%i in ('php -r "echo PHP_VERSION;"') do set PHP_VERSION=%%i
call :log_info "Using PHP version: !PHP_VERSION!"

goto :eof

:ensure_node_dependencies
call :log_step "Checking Node.js Dependencies"

call :check_command npm
if !errorlevel! neq 0 goto :eof

if not exist "%NODE_MODULES_DIR%\.bin" (
    call :log_warning "Node modules directory missing or empty. Installing npm dependencies..."
    call :run_command "Installing npm dependencies" "npm install"
) else (
    call :log_success "npm dependencies are already installed"
)

REM Verify Node.js version
for /f "tokens=*" %%i in ('node --version') do set NODE_VERSION=%%i
call :log_info "Using Node.js version: !NODE_VERSION!"

goto :eof

REM =============================================================================
REM Quality Assurance Tools
REM =============================================================================

:run_prettier
call :log_step "Running Prettier (JavaScript/CSS/JSON Formatter)"

if "%~1"=="fix" (
    call :run_command "Formatting files with Prettier" "npm run prettier:fix"
) else (
    call :run_command "Checking code formatting with Prettier" "npm run prettier"
)
goto :eof

:run_stylelint
call :log_step "Running Stylelint (CSS/SCSS Linter)"

if "%~1"=="fix" (
    call :run_command "Fixing CSS/SCSS issues with Stylelint" "npm run stylelint:fix"
) else (
    call :run_command "Checking CSS/SCSS with Stylelint" "npm run stylelint"
)
goto :eof

:run_pint
call :log_step "Running Laravel Pint (PHP Code Formatter)"

if "%~1"=="fix" (
    call :run_command "Formatting PHP code with Pint" "vendor\bin\pint.bat --verbose"
) else (
    call :run_command "Checking PHP code formatting with Pint" "vendor\bin\pint.bat --test --verbose"
)
goto :eof

:run_phpdocumentor
call :log_step "Running phpDocumentor (Documentation Generator)"

set "OUTPUT_DIR=%QA_RESULTS_DIR%\phpdoc"
if not exist "%OUTPUT_DIR%" mkdir "%OUTPUT_DIR%"

call :run_command "Generating PHP documentation with phpDocumentor" "php -d memory_limit=-1 phpDocumentor.phar --directory=app --target=%OUTPUT_DIR% --ansi"

call :log_info "Documentation generated at: %OUTPUT_DIR%"
goto :eof

:run_larastan
call :log_step "Running Larastan (Static Analysis)"

set "REPORT_FILE=%QA_RESULTS_DIR%\larastan-report.txt"

REM Clear Laravel caches
call :run_command "Clearing Laravel configuration cache" "php artisan config:clear --no-interaction"
call :run_command "Clearing Laravel route cache" "php artisan route:clear --no-interaction"
call :run_command "Clearing Laravel view cache" "php artisan view:clear --no-interaction"

REM Run static analysis
vendor\bin\phpstan.bat analyse --configuration=phpstan.neon --error-format=table --ansi --no-progress > "%REPORT_FILE%" 2>&1
if !errorlevel! neq 0 (
    call :log_warning "Larastan found issues. Check report: %REPORT_FILE%"
    type "%REPORT_FILE%"
    exit /b %EXIT_TOOL_ERROR%
) else (
    call :log_success "Static analysis completed. Report saved: %REPORT_FILE%"
)
goto :eof

:run_microscope
call :log_step "Running Laravel Microscope (Laravel-specific Checks)"

set "REPORT_FILE=%QA_RESULTS_DIR%\microscope-report.txt"

php artisan microscope --no-interaction --ansi > "%REPORT_FILE%" 2>&1
if !errorlevel! neq 0 (
    call :log_warning "Laravel Microscope found issues. Check report: %REPORT_FILE%"
    type "%REPORT_FILE%"
    exit /b %EXIT_TOOL_ERROR%
) else (
    call :log_success "Laravel Microscope checks completed. Report saved: %REPORT_FILE%"
)
goto :eof

:run_phpinsights
call :log_step "Running PHP Insights (Architectural Quality Analysis)"

set "REPORT_FILE=%QA_RESULTS_DIR%\phpinsights-report.json"

php artisan insights --no-interaction --ansi --format=json --output-file="%REPORT_FILE%" 2>&1
if !errorlevel! neq 0 (
    call :log_warning "PHP Insights found issues. Check report: %REPORT_FILE%"
    php artisan insights --no-interaction --ansi > "%QA_RESULTS_DIR%\phpinsights-report.txt" 2>&1
    exit /b %EXIT_TOOL_ERROR%
) else (
    call :log_success "PHP Insights analysis completed. Report saved: %REPORT_FILE%"
)
goto :eof

:run_tests
call :log_step "Running Test Suite"

set "TEST_REPORT=%QA_RESULTS_DIR%\test-results.xml"

call :run_command "Preparing test environment" "php artisan config:clear --no-interaction"
call :run_command "Running PHPUnit tests" "vendor\bin\phpunit.bat --configuration=phpunit.xml --log-junit=%TEST_REPORT% --testdox --colors=always"

call :log_success "All tests passed! Report saved: %TEST_REPORT%"
goto :eof

REM =============================================================================
REM Main Execution Logic
REM =============================================================================

:show_header
echo.
echo ╔════════════════════════════════════════════════════════════════════════════════╗
echo ║                        Laravel Quality Assurance Script                       ║
echo ║                                                                                ║
echo ║  This script runs comprehensive quality checks for your Laravel application   ║
echo ║  including formatting, static analysis, documentation, and architectural      ║
echo ║  quality analysis.                                                             ║
echo ║                                                                                ║
echo ║  Usage:                                                                        ║
echo ║    qa.bat           - Run all quality checks                                  ║
echo ║    qa.bat fix       - Run all quality checks and auto-fix issues             ║
echo ║    qa.bat --help    - Show this help message                                  ║
echo ╚════════════════════════════════════════════════════════════════════════════════╝
echo.
goto :eof

:show_usage
call :show_header
echo Options:
echo   (no args)    Run all quality checks in check-only mode
echo   fix          Run quality checks and automatically fix issues where possible
echo   --help       Show this help message and exit
echo.
echo Quality Tools Included:
echo   • Prettier      - JavaScript/CSS/JSON formatting
echo   • Stylelint     - CSS/SCSS linting
echo   • Laravel Pint  - PHP code formatting (PSR-12)
echo   • phpDocumentor - PHP documentation generation
echo   • Larastan      - Static analysis for Laravel (PHPStan)
echo   • Microscope    - Laravel-specific code analysis
echo   • PHP Insights  - Architectural quality analysis
echo   • PHPUnit       - Test suite execution
echo.
echo Results will be saved in: %QA_RESULTS_DIR%
echo.
goto :eof

:main
set "MODE=%~1"
if "%MODE%"=="" set "MODE=check"

REM Handle help flag
if "%MODE%"=="--help" goto :show_usage_and_exit
if "%MODE%"=="-h" goto :show_usage_and_exit

REM Validate mode
if "%MODE%" neq "check" if "%MODE%" neq "fix" (
    call :log_error "Invalid mode: %MODE%. Use 'check', 'fix', or '--help'"
    call :show_usage
    exit /b %EXIT_SETUP_ERROR%
)

call :show_header
call :log_info "Starting Laravel Quality Assurance in '%MODE%' mode..."
call :log_info "Project root: %PROJECT_ROOT%"

REM Setup results directory
if not exist "%QA_RESULTS_DIR%" (
    mkdir "%QA_RESULTS_DIR%"
    call :log_success "Created QA results directory: %QA_RESULTS_DIR%"
)

REM Ensure dependencies are installed
call :ensure_php_dependencies
if !errorlevel! neq 0 exit /b !errorlevel!

call :ensure_node_dependencies
if !errorlevel! neq 0 exit /b !errorlevel!

REM Change to project directory
cd /d "%PROJECT_ROOT%"

call :log_step "Quality Assurance Execution Plan"
call :log_info "The following tools will be executed in sequence:"
call :log_info "1. Prettier (JavaScript/CSS/JSON formatting)"
call :log_info "2. Stylelint (CSS/SCSS linting)"
call :log_info "3. Laravel Pint (PHP formatting)"
call :log_info "4. phpDocumentor (Documentation generation)"
call :log_info "5. Larastan (Static analysis)"
call :log_info "6. Laravel Microscope (Laravel-specific checks)"
call :log_info "7. PHP Insights (Architectural analysis)"
call :log_info "8. PHPUnit (Test suite)"
echo.

REM Execute quality tools in logical order
call :run_prettier "%MODE%"
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_stylelint "%MODE%"
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_pint "%MODE%"
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_phpdocumentor
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_larastan
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_microscope
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_phpinsights
if !errorlevel! neq 0 exit /b !errorlevel!

call :run_tests
if !errorlevel! neq 0 exit /b !errorlevel!

echo.
call :log_success "🎉 All quality assurance checks completed successfully!"
call :log_success "Results saved in: %QA_RESULTS_DIR%"

if "%MODE%"=="check" (
    echo.
    call :log_info "💡 To automatically fix formatting issues, run: qa.bat fix"
)

echo.
call :log_info "📊 Quality reports generated:"
for %%f in ("%QA_RESULTS_DIR%\*.txt" "%QA_RESULTS_DIR%\*.json" "%QA_RESULTS_DIR%\*.xml") do (
    if exist "%%f" call :log_info "  • %%~nxf: %%f"
)

goto :eof

:show_usage_and_exit
call :show_usage
exit /b %EXIT_SUCCESS%
