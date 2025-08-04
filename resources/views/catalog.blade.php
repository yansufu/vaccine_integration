@extends('layouts.app')

@section('content')
  <div class="vaccine-search-wrapper">
        <div class="vaccine-search-container">
            <!-- Form Section -->
            <div class="vaccine-form-section">
                <h1 class="vaccine-form-title">Fill the details and Location.</h1>

                <form id="vaccineSearchForm" action="{{ route('catalog') }}" method="GET">
                    <div class="vaccine-form-group">
                        <input type="text" name="vaccine_type" class="vaccine-form-input"
                               placeholder="Type of Vaccine" value="">
                    </div>

                    <div class="vaccine-form-group">
                        <input type="text" name="location" class="vaccine-form-input"
                               placeholder="Location" value="">
                    </div>

                    <div class="vaccine-form-group">
                        <input type="date" name="date_from" class="vaccine-form-input" value="{{ request('date_from') }}">
                    </div>
                    <button type="submit" class="vaccine-submit-btn">Search Appointment</button>
                </form>
            </div>
        </div>
    </div>

@if($results->count() || request()->hasAny(['vaccine_type', 'location', 'date_from', 'date_to']))
<div class="container justify-content-center align-items-center p-5 shadow p-3 mb-5 rounded mt-5" style="background-color: #CBEEFF">
    <h2 class="fw-bold text-center">SPECIFICATION</h2>
    <div class="row">
        <div class="col-3 text-center py-2">
            <h4 class="text-uppercase">{{ request('vaccine_type') ?? '-' }}</h4>
            <p>Type of Vaccine</p>
        </div>
        <div class="col-3 text-center">
            <h4 class="text-uppercase">{{ request('location') ?? '-' }}</h4>
            <p>Location</p>
        </div>
        <div class="col-3 text-center">
            @php
                $dateDisplay = '-';
                if (request('date_from') && request('date_to')) {
                    $dateDisplay = request('date_from') . ' to ' . request('date_to');
                } elseif (request('date_from')) {
                    $dateDisplay = request('date_from');
                }
            @endphp
            <h4 class="text-uppercase fs-5">{{ $dateDisplay }}</h4>
            <p>Vaccine Date</p>
        </div>
        <div class="col-3 text-center">
            @if($results->count() > 0)
                <h4 class="text-uppercase text-success">Available</h4>
                <p>Status</p>
            @else
                <h4 class="text-uppercase text-danger">Not Available</h4>
                <p>Status</p>
            @endif
        </div>
    </div>
</div>

<div class="container">
    <h1 class="fw-bold text-uppercase"> Result register : </h1>
    <div class="row">
        @foreach($results as $item)
        <div class="col-md-3 mb-4">
            <div class="card shadow p-3 mb-5 rounded mt-5" style="width: 100%;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('images/avatar.png') }}" width="40" alt="">
                        </div>
                        <div class="col">
                            <h5 class="card-title">{{ $item->org_name ?? '-' }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $item->alamat ?? '-' }}</h6>
                        </div>
                    </div>

                    @if($item->catalogs && count($item->catalogs))
                        <h5 class="mt-3">List of Available Vaccines</h5>
                        @foreach($item->catalogs as $vaccine)
                            <small class="text-muted">
                                {{ $vaccine->vaccination_date ? \Carbon\Carbon::parse($vaccine->vaccination_date)->format('d-m-Y') : '-' }}
                            </small><br>
                            <div class="mb-2 p-2 text-center text-light" style="background-color: #F4ADCD; border-radius: 12px;">
                                <strong>{{ optional($vaccine->category)->category ?? '-' }}</strong><br>
                            </div>
                            <small class="fw-bold">
                                <img src="{{ asset('images/tdesign_money-filled.png') }}" alt="">
                                Rp {{ number_format($vaccine->price ?? 0, 0, ',', '.') }}
                            </small>
                            <br><br>
                        @endforeach
                    @else
                        <p class="mt-3 text-muted">No vaccines available</p>
                    @endif


                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
    <p class="text-center mt-5">No data to show</p>
@endif


<div class="container  justify-content-center align-items-center mt-5 mb-5">
    <div class="row">
<img src="{{asset('images/Rectangle 48.png')}}" alt="">
    </div>
<div class="row justify-content-center align-items-center">
    <h2 class="fw-bold text-uppercase text-center mt-5 fs-1">Polio</h2>

    <p>
        The polio vaccine is a vaccine that prevents polio, a disease caused by a virus that can lead to paralysis and even death. The polio vaccine is part of the mandatory immunization for infants and children. Polio immunization is given to babies from birth until they are under five years old. <br>
        <span class="fw-bold">Types of vaccines:</span>
        <ul>
            <li>There are two types of polio vaccines: oral polio vaccine (OPV) and inactivated polio vaccine (IPV). OPV uses a weakened live polio virus, while IPV uses an inactivated (killed) polio virus.</li>
        </ul>

        <span class="fw-bold">Benefits:</span>
        <ul>
            <li>
                The polio vaccine protects the body from polio virus infection and prevents the occurrence of polio disease.
            </li>
        </ul>

        <span class="fw-bold">Side effects:</span>
        <ul>
            <li>Common side effects after receiving the polio vaccine include mild fever, pain at the injection site, and mild diarrhea.</li>
        </ul>
    </p>

</div>


</div>
@endsection
