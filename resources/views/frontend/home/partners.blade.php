<div class="w-full overflow-hidden bg-white py-5">
   @php
      $items = [
         'partner1.png',
         'partner2.png',
         'partner3.png',
         'partner4.png',
         'partner5.png',
         'partner6.png',
      ];

      $marqueeItems = array_merge($items, $items);
   @endphp
   <div class="flex items-center justify-center">
      <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5 mb-14">
         <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
            Trusted by 100+ Healthcare Partners
         </p>
      </div>
   </div>
   <div class="flex w-max animate-marquee hover:[animation-play-state:paused]">
      @foreach ($marqueeItems as $item)
         <div class="flex items-center justify-center mx-10 shrink-0">
            <img src="{{ asset('assets/' . $item) }}" alt="Partner Logo"
               class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-300">
         </div>
      @endforeach
   </div>
</div>