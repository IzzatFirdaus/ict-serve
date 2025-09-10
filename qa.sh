#!/bin/bash

# =============================================================================
# Laravel Quality Assurance Script (qa.sh)
# =============================================================================
# A comprehensive quality assurance script for modern Laravel applications.
# This script serves as a single-point-of-truth for all local quality checks
# and is designed to be usable in CI/CD pipelines.
#
# Author: Senior DevOps Engineer
# Version: 1.0.0
# Compatible: Laravel 12+, PHP 8.2+, Node.js
# =============================================================================

set -euo pipefail  # Exit on any error, undefined variable, or pipe failure

# Color codes for output formatting
readonly RED='\033[0;31m'
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly BLUE='\033[0;34m'
readonly PURPLE='\033[0;35m'
readonly CYAN='\033[0;36m'
readonly NC='\033[0m' # No Color

# Configuration
readonly SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
readonly PROJECT_ROOT="$SCRIPT_DIR"
readonly VENDOR_DIR="$PROJECT_ROOT/vendor"
readonly NODE_MODULES_DIR="$PROJECT_ROOT/node_modules"
readonly QA_RESULTS_DIR="$PROJECT_ROOT/qa-results"

# Exit codes
readonly EXIT_SUCCESS=0
readonly EXIT_DEPENDENCY_ERROR=1
readonly EXIT_TOOL_ERROR=2
readonly EXIT_SETUP_ERROR=3

# =============================================================================
# Utility Functions
# =============================================================================

# Print colored output with timestamps
log() {
    local color="$1"
    local message="$2"
    local timestamp="$(date '+%Y-%m-%d %H:%M:%S')"
    echo -e "${color}[${timestamp}] ${message}${NC}"
}

# Print info messages
log_info() {
    log "$BLUE" "ℹ️  $1"
}

# Print success messages
log_success() {
    log "$GREEN" "✅ $1"
}

# Print warning messages
log_warning() {
    log "$YELLOW" "⚠️  $1"
}

# Print error messages
log_error() {
    log "$RED" "❌ $1"
}

# Print step headers
log_step() {
    echo ""
    log "$CYAN" "🔧 $1"
    echo "$(printf '%*s' "${#1}" | tr ' ' '=')"
}

# Check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Check if directory exists and is not empty
dir_exists_and_not_empty() {
    [ -d "$1" ] && [ "$(ls -A "$1" 2>/dev/null)" ]
}

# Run command with error handling
run_command() {
    local description="$1"
    shift
    local cmd=("$@")

    log_info "$description"

    if "${cmd[@]}"; then
        log_success "$description completed successfully"
        return $EXIT_SUCCESS
    else
        local exit_code=$?
        log_error "$description failed with exit code $exit_code"
        log_error "Command: ${cmd[*]}"
        return $exit_code
    fi
}

# Create results directory
setup_results_directory() {
    if [ ! -d "$QA_RESULTS_DIR" ]; then
        mkdir -p "$QA_RESULTS_DIR"
        log_success "Created QA results directory: $QA_RESULTS_DIR"
    fi
}

# =============================================================================
# Dependency Management
# =============================================================================

# Check and install PHP dependencies
ensure_php_dependencies() {
    log_step "Checking PHP Dependencies"

    if ! command_exists composer; then
        log_error "Composer is not installed or not in PATH"
        log_error "Please install Composer: https://getcomposer.org/download/"
        exit $EXIT_DEPENDENCY_ERROR
    fi

    if ! dir_exists_and_not_empty "$VENDOR_DIR"; then
        log_warning "Vendor directory missing or empty. Installing Composer dependencies..."
        run_command "Installing Composer dependencies" composer install --no-interaction --prefer-dist --optimize-autoloader
    else
        log_success "Composer dependencies are already installed"
        # Verify critical tools are available
        local missing_tools=()

        [ ! -f "$VENDOR_DIR/bin/pint" ] && missing_tools+=("laravel/pint")
        [ ! -f "$VENDOR_DIR/bin/phpstan" ] && missing_tools+=("larastan/larastan")
        [ ! -f "$PROJECT_ROOT/phpDocumentor.phar" ] && missing_tools+=("phpdocumentor")

        if [ ${#missing_tools[@]} -gt 0 ]; then
            log_warning "Some PHP QA tools are missing: ${missing_tools[*]}"
            log_info "Running composer install to ensure all dependencies are available..."
            run_command "Updating Composer dependencies" composer install --no-interaction --prefer-dist --optimize-autoloader
        fi
    fi

    # Verify PHP version compatibility
    local php_version
    php_version=$(php -r "echo PHP_VERSION;")
    log_info "Using PHP version: $php_version"

    if ! php -r "exit(version_compare(PHP_VERSION, '8.2.0', '>=') ? 0 : 1);"; then
        log_error "PHP 8.2+ is required. Current version: $php_version"
        exit $EXIT_DEPENDENCY_ERROR
    fi
}

# Check and install Node.js dependencies
ensure_node_dependencies() {
    log_step "Checking Node.js Dependencies"

    if ! command_exists npm; then
        log_error "npm is not installed or not in PATH"
        log_error "Please install Node.js and npm: https://nodejs.org/"
        exit $EXIT_DEPENDENCY_ERROR
    fi

    if ! dir_exists_and_not_empty "$NODE_MODULES_DIR"; then
        log_warning "Node modules directory missing or empty. Installing npm dependencies..."
        run_command "Installing npm dependencies" npm install
    else
        log_success "npm dependencies are already installed"
        # Verify critical tools are available
        local missing_tools=()

        [ ! -f "$NODE_MODULES_DIR/.bin/prettier" ] && missing_tools+=("prettier")
        [ ! -f "$NODE_MODULES_DIR/.bin/stylelint" ] && missing_tools+=("stylelint")

        if [ ${#missing_tools[@]} -gt 0 ]; then
            log_warning "Some Node.js QA tools are missing: ${missing_tools[*]}"
            log_info "Running npm install to ensure all dependencies are available..."
            run_command "Updating npm dependencies" npm install
        fi
    fi

    # Verify Node.js version
    local node_version
    node_version=$(node --version)
    log_info "Using Node.js version: $node_version"
}

# =============================================================================
# Quality Assurance Tools
# =============================================================================

# Run Prettier formatting for JavaScript/CSS/JSON files
run_prettier() {
    log_step "Running Prettier (JavaScript/CSS/JSON Formatter)"

    if [ "$1" = "fix" ]; then
        run_command "Formatting files with Prettier" npm run prettier:fix
    else
        run_command "Checking code formatting with Prettier" npm run prettier
    fi
}

# Run Stylelint for CSS/SCSS files
run_stylelint() {
    log_step "Running Stylelint (CSS/SCSS Linter)"

    if [ "$1" = "fix" ]; then
        run_command "Fixing CSS/SCSS issues with Stylelint" npm run stylelint:fix
    else
        run_command "Checking CSS/SCSS with Stylelint" npm run stylelint
    fi
}

# Run Laravel Pint for PHP formatting
run_pint() {
    log_step "Running Laravel Pint (PHP Code Formatter)"

    if [ "$1" = "fix" ]; then
        run_command "Formatting PHP code with Pint" "$VENDOR_DIR/bin/pint" --verbose
    else
        run_command "Checking PHP code formatting with Pint" "$VENDOR_DIR/bin/pint" --test --verbose
    fi
}

# Generate/validate PHP documentation
run_phpdocumentor() {
    log_step "Running phpDocumentor (Documentation Generator)"

    local output_dir="$QA_RESULTS_DIR/phpdoc"

    # Ensure output directory exists
    mkdir -p "$output_dir"

    run_command "Generating PHP documentation with phpDocumentor" \
        php -d memory_limit=-1 "$PROJECT_ROOT/phpDocumentor.phar" \
        --directory=app \
        --target="$output_dir" \
        --cache-folder="$QA_RESULTS_DIR/.phpdoc-cache" \
        --ansi

    log_info "Documentation generated at: $output_dir"
}

# Run Larastan (PHPStan for Laravel)
run_larastan() {
    log_step "Running Larastan (Static Analysis)"

    local report_file="$QA_RESULTS_DIR/larastan-report.txt"

    # Clear Laravel caches that might interfere with static analysis
    run_command "Clearing Laravel configuration cache" php artisan config:clear --no-interaction
    run_command "Clearing Laravel route cache" php artisan route:clear --no-interaction
    run_command "Clearing Laravel view cache" php artisan view:clear --no-interaction

    # Run static analysis with detailed output
    run_command "Running static analysis with Larastan" \
        "$VENDOR_DIR/bin/phpstan" analyse \
        --configuration=phpstan.neon \
        --error-format=table \
        --ansi \
        --no-progress > "$report_file" || {
        log_warning "Larastan found issues. Check report: $report_file"
        cat "$report_file"
        return $EXIT_TOOL_ERROR
    }

    log_success "Static analysis completed. Report saved: $report_file"
}

# Run Laravel Microscope
run_microscope() {
    log_step "Running Laravel Microscope (Laravel-specific Checks)"

    local report_file="$QA_RESULTS_DIR/microscope-report.txt"

    # Run microscope checks
    if php artisan microscope --no-interaction --ansi > "$report_file" 2>&1; then
        log_success "Laravel Microscope checks completed. Report saved: $report_file"
    else
        log_warning "Laravel Microscope found issues. Check report: $report_file"
        cat "$report_file"
        return $EXIT_TOOL_ERROR
    fi
}

# Run PHP Insights
run_phpinsights() {
    log_step "Running PHP Insights (Architectural Quality Analysis)"

    local report_file="$QA_RESULTS_DIR/phpinsights-report.json"

    # Run PHP Insights in non-interactive mode
    run_command "Analyzing code quality with PHP Insights" \
        php artisan insights \
        --no-interaction \
        --ansi \
        --format=json \
        --output-file="$report_file" || {
        log_warning "PHP Insights found issues. Check report: $report_file"
        # Also generate a human-readable report
        php artisan insights --no-interaction --ansi > "$QA_RESULTS_DIR/phpinsights-report.txt" || true
        return $EXIT_TOOL_ERROR
    }

    log_success "PHP Insights analysis completed. Report saved: $report_file"
}

# Run all tests to ensure code quality doesn't break functionality
run_tests() {
    log_step "Running Test Suite"

    local test_report="$QA_RESULTS_DIR/test-results.xml"

    # Clear caches before testing
    run_command "Preparing test environment" php artisan config:clear --no-interaction

    # Run PHPUnit tests with coverage and JUnit output
    run_command "Running PHPUnit tests" \
        "$VENDOR_DIR/bin/phpunit" \
        --configuration=phpunit.xml \
        --log-junit="$test_report" \
        --testdox \
        --colors=always

    log_success "All tests passed! Report saved: $test_report"
}

# =============================================================================
# Main Execution Logic
# =============================================================================

# Display script header and information
show_header() {
    echo ""
    echo "╔════════════════════════════════════════════════════════════════════════════════╗"
    echo "║                        Laravel Quality Assurance Script                       ║"
    echo "║                                                                                ║"
    echo "║  This script runs comprehensive quality checks for your Laravel application   ║"
    echo "║  including formatting, static analysis, documentation, and architectural      ║"
    echo "║  quality analysis.                                                             ║"
    echo "║                                                                                ║"
    echo "║  Usage:                                                                        ║"
    echo "║    ./qa.sh           - Run all quality checks                                 ║"
    echo "║    ./qa.sh fix       - Run all quality checks and auto-fix issues            ║"
    echo "║    ./qa.sh --help    - Show this help message                                 ║"
    echo "╚════════════════════════════════════════════════════════════════════════════════╝"
    echo ""
}

# Show usage information
show_usage() {
    show_header
    echo "Options:"
    echo "  (no args)    Run all quality checks in check-only mode"
    echo "  fix          Run quality checks and automatically fix issues where possible"
    echo "  --help       Show this help message and exit"
    echo ""
    echo "Quality Tools Included:"
    echo "  • Prettier      - JavaScript/CSS/JSON formatting"
    echo "  • Stylelint     - CSS/SCSS linting"
    echo "  • Laravel Pint  - PHP code formatting (PSR-12)"
    echo "  • phpDocumentor - PHP documentation generation"
    echo "  • Larastan      - Static analysis for Laravel (PHPStan)"
    echo "  • Microscope    - Laravel-specific code analysis"
    echo "  • PHP Insights  - Architectural quality analysis"
    echo "  • PHPUnit       - Test suite execution"
    echo ""
    echo "Results will be saved in: $QA_RESULTS_DIR"
    echo ""
}

# Main execution function
main() {
    local mode="${1:-check}"
    local start_time
    start_time=$(date +%s)

    # Handle help flag
    if [[ "$mode" == "--help" || "$mode" == "-h" ]]; then
        show_usage
        exit $EXIT_SUCCESS
    fi

    # Validate mode
    if [[ "$mode" != "check" && "$mode" != "fix" ]]; then
        log_error "Invalid mode: $mode. Use 'check', 'fix', or '--help'"
        show_usage
        exit $EXIT_SETUP_ERROR
    fi

    show_header
    log_info "Starting Laravel Quality Assurance in '$mode' mode..."
    log_info "Project root: $PROJECT_ROOT"

    # Setup
    setup_results_directory

    # Ensure dependencies are installed (idempotent)
    ensure_php_dependencies
    ensure_node_dependencies

    # Change to project directory
    cd "$PROJECT_ROOT"

    log_step "Quality Assurance Execution Plan"
    log_info "The following tools will be executed in sequence:"
    log_info "1. Prettier (JavaScript/CSS/JSON formatting)"
    log_info "2. Stylelint (CSS/SCSS linting)"
    log_info "3. Laravel Pint (PHP formatting)"
    log_info "4. phpDocumentor (Documentation generation)"
    log_info "5. Larastan (Static analysis)"
    log_info "6. Laravel Microscope (Laravel-specific checks)"
    log_info "7. PHP Insights (Architectural analysis)"
    log_info "8. PHPUnit (Test suite)"
    echo ""

    # Execute quality tools in logical order
    # Formatters first (these can fix issues automatically)
    run_prettier "$mode"
    run_stylelint "$mode"
    run_pint "$mode"

    # Documentation and analysis tools
    run_phpdocumentor
    run_larastan
    run_microscope
    run_phpinsights

    # Finally, run tests to ensure everything works
    run_tests

    # Summary
    local end_time
    local duration
    end_time=$(date +%s)
    duration=$((end_time - start_time))

    echo ""
    log_success "🎉 All quality assurance checks completed successfully!"
    log_success "Total execution time: ${duration}s"
    log_success "Results saved in: $QA_RESULTS_DIR"

    # Provide next steps based on mode
    if [[ "$mode" == "check" ]]; then
        echo ""
        log_info "💡 To automatically fix formatting issues, run: ./qa.sh fix"
    fi

    echo ""
    log_info "📊 Quality reports generated:"
    find "$QA_RESULTS_DIR" -type f -name "*.txt" -o -name "*.json" -o -name "*.xml" 2>/dev/null | while read -r file; do
        log_info "  • $(basename "$file"): $file"
    done
}

# =============================================================================
# Script Entry Point
# =============================================================================

# Trap to handle script interruption
trap 'log_error "Quality assurance script interrupted"; exit 130' INT TERM

# Check if script is being sourced or executed directly
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
