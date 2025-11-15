<div class="col-xl-6">
    <div class="fact-counters">
        <div class="row gy-5 gx-5">
          
            @foreach ($statistics as  $statistic)
            <div class="col-md-6">
                <div class="counter-box style2">
                    <div class="counter">
                        <span class="counter-number">{{ $statistic->value }}</span> <span class="plus">+</span>
                    </div>
                    <div class="line"></div>
                    <p class="text">{{ $statistic->title }}</p>
                </div>
            </div>
            @endforeach
            
          
        </div>
    </div>
</div>