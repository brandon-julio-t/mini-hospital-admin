@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">{{ $patient->id }} Receipt</div>

        <div class="card-body">
            <aside class="row">
                <div class="col text-left">
                    <p>
                        Patient admitted at:
                        <br>
                        {{ $receipt->created_at }}
                    </p>
                </div>
                <div class="col text-right">
                    <p>
                        Patient discharged at:
                        <br>
                        {{ $receipt->finalized_at }}
                    </p>
                </div>
            </aside>

            <section class="my-5">
                <h2>Patient</h2>
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th scope="row">ID</th>
                            <td>{{ $patient->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Date of Birth</th>
                            <td>{{ $patient->date_of_birth }}</td>
                        </tr>
                    </table>
                </div>
            </section>

            <section class="my-5">
                <h2>Medicines</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Disease</th>
                            <th scope="col">Use</th>
                            <th scope="col">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($medicines as $medicine)
                            <tr>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->disease }}</td>
                                <td>{{ $medicine->type }}</td>
                                <td class="text-right">{{ $medicine->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="my-5">
                <h2>Doctor Charges</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($doctorCharges as $doctorCharge)
                            <tr>
                                <td>{{ $doctorCharge->name }}</td>
                                <td class="text-right">Rp{{ number_format($doctorCharge->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <th scope="row">Subtotal</th>
                            <td class="text-right">Rp{{ number_format($doctorChargeSubtotal->subtotal) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="my-5">
                <h2>Hospital Charges</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hospitalCharges as $hospitalCharge)
                            <tr>
                                <td>{{ $hospitalCharge->name }}</td>
                                <td class="text-right">Rp{{ number_format($hospitalCharge->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <th scope="row">Subtotal</th>
                            <td class="text-right">Rp{{ number_format($hospitalChargeSubtotal->subtotal) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="row my-5">
                <div class="col text-left">
                    <h2>Grand Total</h2>
                </div>
                <div class="col text-right">
                    <h2>Rp{{ number_format($doctorChargeSubtotal->subtotal + $hospitalChargeSubtotal->subtotal) }}</h2>
                </div>
            </section>

            <a href="{{ route('home') }}" class="btn btn-block btn-outline-dark">Return</a>
        </div>
    </div>
@endsection
