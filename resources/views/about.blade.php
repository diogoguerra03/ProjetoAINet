@extends('layouts.footer')
@extends('layouts.header')
@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>About Us</h1>
        <p>
            Welcome to Imagine Shirt! We are a brand created by three college students: Rafael, Diogo, and Lucas. Let us tell you our story.
        </p>

        <h2>Our Story</h2>
        <p>
            Imagine Shirt was born out of our passion for fashion and creativity. As college students, we often found ourselves frustrated with the lack of unique and stylish clothing options available in the market. We saw an opportunity to fill this gap and create a brand that reflects our vision and values.
        </p>
        <p>
            We started Imagine Shirt in our dorm room, with nothing but a sewing machine, some fabric, and a whole lot of ambition. We spent countless late nights designing and refining our first collection, pouring our hearts into every stitch.
        </p>
        <p>
            Our brand quickly gained attention among our friends and fellow students, and the positive feedback fueled our determination to turn Imagine Shirt into something bigger. Today, we are proud to offer our carefully crafted garments to customers all around the world.
        </p>

        <h2>Our Goal</h2>
        <p>
            At Imagine Shirt, our goal is to inspire self-expression and empower individuals to embrace their uniqueness. We believe that what you wear is an extension of your personality and a powerful way to make a statement. Our aim is to provide you with clothing that not only looks good but also makes you feel confident and comfortable in your own skin.
        </p>
        <p>
            We are committed to delivering high-quality products that are ethically made and environmentally friendly. Sustainability is a core value of our brand, and we continuously strive to minimize our impact on the planet throughout our production process.
        </p>

        <h2 class="mt-5 mb-0">Meet the Team</h2>
        <div class="row d-flex justify-content-around mb-5">
            <div class="col-md-4">
                <div class="d-flex justify-content-center">
                    <img class="rounded-circle m-5 mx-auto" style="height: 250px" src="assets/images/rafael.jpeg"  alt="Rafael">
                </div>
                <div class="d-flex justify-content-center">
                    <h3>Rafael</h3>
                </div>
                <div class="d-flex justify-content-center">
                    <p>Co-founder and Creative Director</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-center">
                    <img class="rounded-circle m-5 mx-auto" style="height: 250px" src="assets/images/diogo.jpeg" class="img-fluid image-container" alt="Diogo">
                </div>
                <div class="d-flex justify-content-center">
                    <h3>Diogo</h3>
                </div>
                <div class="d-flex justify-content-center">
                    <p>Co-founder and Head of Design</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-center">
                    <img class="rounded-circle m-5 mx-auto" style="height: 250px" src="assets/images/lucas.jpeg" class="img-fluid image-container" alt="Lucas">
                </div>
                <div class="d-flex justify-content-center">
                    <h3 class="mx-auto">Lucas</h3>
                </div>
                <div class="d-flex justify-content-center">
                    <p>Co-founder and Marketing Strategist</p>
                </div>
            </div>
        </div>
    </div>
@endsection
