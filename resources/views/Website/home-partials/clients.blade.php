@if($clients->isNotEmpty())
    <!--==================clients Section===============================-->
<section class="py-5 bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-5 fw-bold text-main">{{__('website.our_clients')}}</h2>
    <div class="owl-carousel partners-carousel">
      @foreach ($clients as $client)
      <div>
        <div class="bg-white rounded-4 shadow-sm p-4 d-flex align-items-center justify-content-center h-100">
          <img src="{{ $client->logo_path }}" alt="{{ $client->name }}" class="img-fluid" style="max-height: 60px;">
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>
    <!--==================clients Section===============================-->
@endif