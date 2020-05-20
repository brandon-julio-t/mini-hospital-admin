<form action="{{ $route }}" method="POST">
    @csrf
    @method($method)

    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" autocomplete="name" value="{{ old('name') ?? $patient->name ?? '' }}" autofocus
                   required>

            @error('name')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="gender" class="col-sm-3 col-form-label pt-0">Sex</label>
        <div class="col-sm-9">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sex" id="male" value="Male">
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sex" id="female" value="Female">
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                   id="phone_number" name="phone_number" autocomplete="tel-national"
                   value="{{ old('phone_number') ?? $patient->phone_number ?? '' }}" required>

            @error('phone_number')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="date_of_birth" class="col-sm-3 col-form-label">Date of Birth</label>
        <div class="col-sm-4">
            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                   id="date_of_birth" name="date_of_birth"
                   value="{{ old('date_of_birth') ?? $patient->date_of_birth ?? '' }}" required>

            @error('date_of_birth')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="address" class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-9">
            <textarea type="number" class="form-control @error('address') is-invalid @enderror"
                      id="address" name="address" rows="3" required
            >{{ old('address') ?? $patient->address ?? '' }}</textarea>

            @error('address')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="doctor" class="col-sm-3 col-form-label">Doctor</label>
        <div class="col-sm-9">
            <select class="form-control" name="doctor_id" id="doctor_id">
                @forelse(DB::select("select * from doctors") as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialist }})</option>
                @empty
                    <option value="-1">No doctors are available.</option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="form-group row justify-content-center">
        <button type="submit" class="btn btn-outline-primary">Submit</button>
        <div class="mx-2"></div>
        <a href="{{ url()->previous() }}" class="btn btn-outline-dark">Cancel</a>
    </div>
</form>
