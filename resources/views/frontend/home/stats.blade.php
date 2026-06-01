<div class="w-full padding-x pt-20 bg-white">
   <div class="w-full flex items-center justify-center gap-10">
      @php
         $stats = [
            [
               "title" => "24/7",
               "para" => "Customer Support",
               "img" => "fun-fact1.png"
            ],
            [
               "title" => "30",
               "para" => "Years Of Experience",
               "img" => "fun-fact2.png"
            ],
            [
               "title" => "98%",
               "para" => "Positive Review",
               "img" => "fun-fact3.png"
            ],
            [
               "title" => "15k+",
               "para" => "Happy Customer",
               "img" => "fun-fact4.png"
            ],
         ];
      @endphp
      @foreach ($stats as $stat)
         <div
            class="w-[400px] h-[400px] flex flex-col items-center justify-center rounded-full border border-black/10 hover:border-[#F0BB4C] transition-all duration-300">
            <div class="w-20 h-20">
               <img src="{{ asset('assets/' . $stat['img']) }}" alt="{{ $stat['img'] }}">
            </div>
            <h4 class="heading text-black font-bold dmserif leading-normal">{{ $stat['title'] }}</h4>
            <p class="paragraph text-[#666666] font-medium leading-normal">{{ $stat['para'] }}</p>
         </div>
      @endforeach
   </div>
</div>