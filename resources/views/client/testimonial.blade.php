@section('css')
<style>
    .testimonial-form {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
@extends('layouts.client.app_client')

@section('content')
    <div class="jumbotron jumbotron-fluid bg-jumbotron">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">Testimonial</h3>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="">Create</a></p>
                <i class="far fa-circle px-3"></i>
                <p class="m-0">Testimonial</p>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="mb-4">Submit Your Testimonial</h2>
                <div class="testimonial-form">
                    <form method="POST" action="{{ route('client.testimonial.save') }}">
                        @csrf
                        <div class="form-group">
                            <label for="testimonialText">Testimonial</label>
                            <textarea class="form-control" id="testimonialText" name="description" rows="4" placeholder="Write your testimonial" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    @if(session('testimonial_save'))
        Lobibox.notify('success', {
            msg: 'Successfully Added Testimonial',
            img: "{{ asset('img/check.png') }}"
        });
    @endif
</script>
@endsection
