@extends('layouts.slim')

@section('body')

    <div class="card">
        <div class="card-header">Treat Patient</div>

        <div class="card-body">
            <section class="table-responsive">
                <h2>Patient Information</h2>
                <table class="table table-borderless table-hover">
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{ $patient->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">DOB</th>
                        <td>{{ $patient->date_of_birth }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Sex</th>
                        <td>{{ $patient->sex }}</td>
                    </tr>
                </table>
            </section>

            <section>
                <h2>Patient Treatment</h2>

                <form action="{{ route('treat.patient.finish', $patient->id) }}" method="POST">
                    @csrf

                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0">Doctor Charges</legend>
                            <div class="col-sm-9">
                                @forelse(DB::select("select id, replace(name, ' Fee', '') as name from doctor_charges") as $charge)
                                    <div class="form-check">
                                        <input type="checkbox" name="charges[{{ $charge->id }}]" id="{{ $charge->id }}"
                                               class="form-check-input @error('charges') is-invalid @enderror"
                                               @if (Str::of($charge->id)->exactly('DC001')) checked @endif>
                                        <label for="{{ $charge->name }}" class="form-check-label">
                                            {{ $charge->name }}
                                        </label>

                                        @error('charges')
                                        <app-alert message="{{ $message }}"></app-alert>
                                        @enderror
                                    </div>
                                @empty
                                    <div class="form-check">
                                        <input type="checkbox" name="action" id="no-action" class="form-check-input"
                                               disabled>
                                        <label for="no-action" class="form-check-label">No action.</label>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </fieldset>

                    @forelse(DB::select("select * from medicines") as $medicine)
                        <div class="form-group row">
                            <label for="{{ $medicine->id }}" class="col-sm-3 form-col-label">
                                {{ $medicine->name }}
                            </label>
                            <div class="col-sm-9">
                                <input type="number" name="medicines[{{ $medicine->id }}]" id="{{ $medicine->id }}"
                                       class="form-control @if($errors->get('medicines.*')) is-invalid @enderror"
                                       value="0" min="0" required>
                            </div>
                        </div>
                    @empty
                        <div class="form-group row">
                            <label for="no-medicine" class="col-sm-2 form-col-label">No Medicine</label>
                            <div class="col-sm-10">
                                <input type="number" name="no-medicine" id="no-medicine" class="form-control" disabled>
                            </div>
                        </div>
                    @endforelse

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-block btn-outline-dark">Submit</button>
                        </div>
                        <div class="col">
                            <a href="{{ route('home') }}" class="btn btn-block btn-outline-danger">Return</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

@endsection
