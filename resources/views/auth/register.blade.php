@extends('layouts.auth')

@section('content')
<section class="mt-5">
      <div class="page-content page-auth" id="register">
        <div class="section-store-auth">
          <div class="container">
            <div class="row align-items-center justify-content-center row-login">
              <div class="col-lg-4">
                <h2>Memulai untuk jual beli dengan cara terbaru</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
 
                    <div class="form-group">
                    <label for="name">Full Name </label>
                    <input id="name"  type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  v-model="name"  required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" v-model="email" @change="checkForEmailAvailability()" type="email" class="form-control @error('email') is-invalid @enderror" :class="{ 'is-invalid' : this.email_unavailable }" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  <div class="form-group">
                    <label for="password-confirmation">Konfirmasi Password</label>
                    <input id="password-confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  <div class="form-group">
                    <label for="store">Store</label>
                    <p class="text-muted">
                        Apakah anda ingin membuka toko?
                    </p>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" 
                        class="custom-control-input" 
                        name="is_store_open" 
                        id="openStoreTrue"
                        v-model="is_store_open"
                        :value="true"
                        />
                        <label for="openStoreTrue" class="custom-control-label">
                            Iya, Boleh
                        </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" 
                        class="custom-control-input" 
                        name="is_store_open" 
                        id="openStoreFalse"
                        v-model="is_store_open"
                        :value="false"
                        />
                        <label for="openStoreFalse" class="custom-control-label">
                            Enggak, Makasih
                        </label>
                    </div>
                    <div class="form-group mt-3" v-if="is_store_open">
                        <label for="nameToko">Nama Toko </label>
                        <input type="text"
                        class="form-control"
                        v-model="store_name"
                        id="store_name"
                        class="form-control @error('store_name') is-invalid @enderror"
                        name="store_name"
                        required
                        autocomplete
                        autofocus 
                        />
                        @error('store_name')
                        <span class="invalid-feedbcak" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group" v-if="is_store_open">
                        <label for="Kategori">Kategori </label>
                        <select name="categories_id" id="" class="form-control">
                            <option value="" disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div> 
                  </div>
                  <button
                    type="submit"
                    class="btn btn-success btn-block mt-4"
                    :disabled="this.email_unavailable"
                  >
                    Sign Up Now
                  </button>
                  <a
                    href="{{route('login')}}"
                    class="btn btn-signup btn-block mt-4"
                  >
                    Back To Sign In
                  </a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>

@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        Vue.use(Toasted);

        var register = new Vue({
            el: '#register',
            mounted() {
                AOS.init();
            },
            methods: {
              checkForEmailAvailability : function() {
                var self = this;
                axios.get('{{ route('api-register-check') }}', {
                  params: {
                    email: this.email
                  }
                })
                  .then(function(response) {
                    if(response.data == 'Available'){
                      self.$toasted.show(
                        "Email tersedia, silakan lanjutkan langkah selanjutnya!",
                        {
                          position: "top-center",
                          className: "rounded",
                          duration: 1000,
                        }
                      );
                      self.email_unavailable = false;

                    }else {
                      self.$toasted.error(
                        "Maaf, tampaknya email sudah terdaftar pada sistem kami.",
                        {
                          position: "top-center",
                          className: "rounded",
                          duration: 1000,
                        }
                      );
                      self.email_unavailable = true;
                      
                    }

                  });
              }
            },
            data() {
              return {
                name: "Andi Firdana",
                email: "Andi@gmail.com",
                is_store_open: true,
                store_name: "",
                email_unavailable: false
              }
            },
        });
    </script>
@endpush
