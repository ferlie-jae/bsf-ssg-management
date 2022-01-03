@extends('layouts.website')
@section('style')

@endsection
@section('content')
<div class="container mt-3 mb-5 pb-5">
    <div class="row">
        <div class="col-lg-12">
            <h3>Contact Us</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('website.submit_contact_us') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" id="name" name="name" class="form-control" required/>
                    <label class="form-label" for="name">Name</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" required/>
                    <label class="form-label" for="email">Email address</label>
                </div>
                <div class="form-outline mb-4">
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    <label class="form-label" for="message">Message</label>
                </div>
                <button type="submit" class="btn btn-success mb-4">Send</button>
            </form>
        </div>
        <div class="col-lg-6">

        </div>
    </div>
</div>
@endsection
@section('script')

@endsection