<h1>Welcome, {{ Auth::user()->username }}</h1>

<section class="my-5">
    <h2>Manage Staffs</h2>

    @include('admin.tables.staff')
</section>

<section class="my-5">
    <h2>Manage Doctors</h2>

    @include('admin.tables.doctor')
</section>

<div class="row justify-content-center">
    <div class="col">
        <a href="{{ route('staffs.create') }}" class="btn btn-block btn-outline-dark">Add new Staff</a>
    </div>
    <div class="col">
        <a href="{{ route('doctors.create') }}" class="btn btn-block btn-outline-dark">Add new Doctor</a>
    </div>
</div>
