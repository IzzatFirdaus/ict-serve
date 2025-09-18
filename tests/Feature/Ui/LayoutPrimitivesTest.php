<?php

namespace Tests\Feature\Ui;

use Tests\TestCase;

class LayoutPrimitivesTest extends TestCase
{
    public function test_skiplink_renders(): void
    {
        $html = view('components.myds.skiplink')->render();

        $this->assertStringContainsString('Langkau ke kandungan utama', $html);
        $this->assertStringContainsString('myds-skip-link', $html);
        $this->assertStringContainsString('aria-label="Langkau ke kandungan utama"', $html);
    }

    public function test_announce_bar_renders_with_slot(): void
    {
        $html = view('components.myds.announce-bar', ['slot' => 'Ujian pengumuman'])->render();

        $this->assertStringContainsString('role="region"', $html);
        $this->assertStringContainsString('Ujian pengumuman', $html);
        $this->assertStringContainsString('bg-primary-600', $html);
    }

    public function test_phase_banner_renders(): void
    {
        $html = view('components.myds.phase-banner')->render();

        $this->assertStringContainsString('Beta', $html);
        $this->assertStringContainsString('aria-live="polite"', $html);
        $this->assertStringContainsString('bg-warning-50', $html);
    }

    public function test_cookie_banner_contains_text(): void
    {
        $html = view('components.myds.cookie-banner')->render();

        $this->assertStringContainsString('Kami menggunakan kuki', $html);
        $this->assertStringContainsString('myds-btn-primary', $html);
        $this->assertStringContainsString('myds-card', $html);
    }
}
