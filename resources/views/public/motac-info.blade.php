@extends('layouts.app')

@section('content')
    <x-myds.header title="MOTAC Information" />
    <main id="main-content" class="container mx-auto py-8">
        <x-myds.button class="mb-4" href="https://www.motac.gov.my/" target="_blank">Visit MOTAC Official Site</x-myds.button>
        <x-myds.summary-list>
            <x-myds.summary-list-row term="Overview" detail="MOTAC is the Ministry of Tourism, Arts and Culture Malaysia, responsible for tourism, arts, culture, heritage, and related sectors." />
            <x-myds.summary-list-row term="Security Policy" detail="MOTAC uses encryption and strict security standards to protect data. All personal data is stored and transmitted securely." />
            <x-myds.summary-list-row term="Privacy Policy" detail="Personal data submitted may be shared with public agencies for effective service. No data is collected unless submitted by the user." />
            <x-myds.summary-list-row term="Disclaimer" detail="MOTAC is not responsible for any loss or damage from using information on its website. Official content is in Malay and English only." />
            <x-myds.summary-list-row term="Help" detail="Instructions for changing text size, color themes for accessibility, and mobile usage tips are provided on the portal." />
            <x-myds.summary-list-row term="Information Request" detail="For info not on the portal, submit requests to MOTAC’s Corporate Communications Unit. Requests are subject to terms and conditions." />
            <x-myds.summary-list-row term="Sitemap" detail="Quick access to all MOTAC website sections, services, and resources." />
        </x-myds.summary-list>
        <x-myds.footer />
    </main>
@endsection
