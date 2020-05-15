<form action="{{ $route }}" method="POST">
    @csrf
    @method($method)

    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" autocomplete="name" value="{{ old('name') ?? $staff->name ?? '' }}" autofocus
                   required>

            @error('name')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                   id="phone_number" name="phone_number" autocomplete="tel-national"
                   value="{{ old('phone_number') ?? $staff->phone_number ?? '' }}" required>

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
                   value="{{ old('date_of_birth') ?? $staff->date_of_birth ?? '' }}" required>

            @error('date_of_birth')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="role" class="col-sm-3 col-form-label">Role</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('role') is-invalid @enderror"
                   id="role" name="role" value="{{ old('role') ?? $staff->role ?? '' }}" required>

            @error('role')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="salary" class="col-sm-3 col-form-label">Salary</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">Rp</div>
                </div>
                <input type="number" step="any" class="form-control @error('salary') is-invalid @enderror" id="salary"
                       name="salary" value="{{ old('salary') ?? $staff->salary ?? '' }}" required>
            </div>

            @error('salary')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="address" class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-9">
            <textarea type="number" class="form-control @error('address') is-invalid @enderror"
                      id="address" name="address" rows="3" required
            >{{ old('address') ?? $staff->address ?? '' }}</textarea>

            @error('address')
            <app-alert message="{{ $message }}"></app-alert>
            @enderror
        </div>
    </div>

    <div class="form-group row justify-content-center">
        <button type="submit" class="btn btn-outline-primary">Submit</button>
        <div class="mx-2"></div>
        <a href="{{ url()->previous() }}" class="btn btn-outline-dark">Cancel</a>
    </div>
</form>
