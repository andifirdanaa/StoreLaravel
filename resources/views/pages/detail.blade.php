@extends('layouts.app')


@section('title')
    Store Detail Page
@endsection

@section('content')
     <div class="page-content page-details">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="/index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Product Details</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mb-3" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 image-cover" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img
                  :src="photos[activePhoto].url"
                  :key="photos[activePhoto].id"
                  alt=""
                  class="w-100 main-image"
                />
              </transition>
            </div>
            <div class="col-lg-2">
              <div class="row">
                <div
                  class="col-3 col-lg-12 mt-2 mt-lg-0 thumbnail-cover"
                  style="height: 120px"
                  v-for="(photo, index) in photos"
                  :key="photo.id"
                  data-aos="zoom-in"
                  data-aos-delay="100"
                >
                  <a href="#" @click="changeActive(index)">
                    <img
                      :src="photo.url"
                      class="w-100 thumbnail-image"
                      :class="{ active: index == activePhoto }"
                      alt=""
                    />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="store-details-container" data-aos="fade-up">
        <section class="store-heading">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <h1>{{ $product->name}}</h1>
                <div class="owner">By {{$product->user->store_name}}</div>
                <div class="price">${{number_format($product->price)}}</div>
              </div>
              <div class="col-lg-2">
              @auth
                <form action="{{route('detail-add',$product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                  <button
                    type="submit"
                    class="btn btn-success px-4 text-white btn-block mb-3"
                  >
                    Add To Cart
                  </button>
                </form>
              @else
                <a
                  href="{{route('login')}}"
                  class="btn btn-success px-4 text-white btn-block mb-3"
                >
                  Sign in to Add
                </a>
              @endauth
              </div>
            </div>
          </div>
        </section>
        <section class="store-description">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $product->description !!}
              </div>
            </div>
          </div>
        </section>
        <section class="store-review">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8 mb-3">
                <h5>Customer Review (3)</h5>
                <div class="row">
                  <div class="col-12 col-lg-8">
                    <ul class="list-unstyled">
                      <li class="media">
                        <img
                          src="/images/review/image-review-1.png"
                          alt=""
                          class="mr-3 rounded-circle"
                        />
                        <div class="media-body">
                          <h5 class="mt-2 mb-1">Septian Hadi</h5>
                          <p>
                            I thought it was not good for living room. I really
                            happy to decided buy this product last week now
                            feels like homey.
                          </p>
                        </div>
                      </li>
                      <li class="media">
                        <img
                          src="/images/review/image-review-2.png"
                          alt=""
                          class="mr-3 rounded-circle"
                        />
                        <div class="media-body">
                          <h5 class="mt-2 mb-1">Medina Silvia</h5>
                          <p>
                            Color is great with the minimalist concept. Even I
                            thought it was made by Cactus industry. I do really
                            satisfied with this.
                          </p>
                        </div>
                      </li>
                      <li class="media">
                        <img
                          src="/images/review/image-review-3.png"
                          alt=""
                          class="mr-3 rounded-circle"
                        />
                        <div class="media-body">
                          <h5 class="mt-2 mb-1">Septian Hadi</h5>
                          <p>
                            When I saw at first, it was really awesome to have
                            with. Just let me know if there is another upcoming
                            product like this.
                          </p>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach($product->galleries as $gallery)
              {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
              },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
@endpush
