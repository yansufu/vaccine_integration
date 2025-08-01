@extends('layouts.app')

@section('content')

<div class="container">
    <h1  class="fw-bold">Vaccination Result <span style="color: #FF8EA1 "></span></h1>

        <div class="container">
            <h3 class="rounded p-3 text-center fw-bold" style="background-color: #F4ADCD">
                Result Card Shows:
            </h3>

            <div class="row">
                <div class="col border p-2">Name</div>
                <div class="col border p-2">{{ $child->name ?? '-' }}</div>
            </div>

            <div class="row">
                <div class="col border p-2">NIK</div>
                <div class="col border p-2">{{ $child->NIK ?? '-' }}</div>
            </div>

            <div class="row">
            <div class="col border p-2">Age</div>
            <div class="col border p-2">
                @if($child && $child->date_of_birth)
                    @php
                        $dob = \Carbon\Carbon::parse($child->date_of_birth);
                        $ageYears = $dob->age;
                    @endphp
                    {{ $ageYears }} Years
                @else
                    -
                @endif
            </div>
            
        

        </div>


        </div>
        
    </div>

  <div class="container mt-5">
    <h3 class="rounded p-3 text-center fw-bold" style="background-color: #F4ADCD">Basic Immunization Status</h3>

    @if(optional($child)->vaccination && $child->vaccination->count())
        @foreach($child->vaccination as $vaccine)
            <div class="row">
                <div class="col border p-2">{{ $vaccine->vaccine->name ?? '-' }}</div>
                <div class="col border p-2">
                    @php
                        $status = strtolower($vaccine->is_completed ? 'completed' : 'not completed');
                    @endphp

                    @if($status === 'completed')
                        <span class="text-success">✅</span>
                    @else
                        <span class="text-danger">❌</span>
                    @endif

                    <span class="ms-2 text-capitalize">{{ $status }}</span>
                </div>
                <div class="col border p-2">
                    {{ isset($vaccine->created_at) ? \Carbon\Carbon::parse($vaccine->created_at)->format('d M Y') : '-' }}
                </div>
            </div>
        @endforeach

    @else
        <div class="row">
            <div class="col text-center text-muted p-3">
                No vaccination data found.
            </div>
        </div>
    @endif
</div>

</div>
@endsection
