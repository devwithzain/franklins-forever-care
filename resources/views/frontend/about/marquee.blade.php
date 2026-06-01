<div class="w-full overflow-hidden pb-20 marquee-wrapper">
   <div class="marquee-track">
      @php
         $items = [
            'Health Monitoring',
            'Senior Care',
            'Home Support',
            'Daily Assistance',
            'Health Monitoring',
            'Senior Care',
            'Home Support',
            'Daily Assistance',
         ];
        @endphp
      <div class="marquee-content">
         @foreach ($items as $item)
            <span class="marquee-item pr-6">
               <img src="{{ asset('assets/star.png') }}" alt="" class="w-10 h-10 object-contain">
               <span class="marquee-text">{{ $item }}</span>
            </span>
         @endforeach
      </div>
      <div class="marquee-content" aria-hidden="true">
         @foreach ($items as $item)
            <span class="marquee-item">
               <img src="{{ asset('assets/star.png') }}" alt="" class="w-10 h-10 object-contain">
               <span class="marquee-text">{{ $item }}</span>
            </span>
         @endforeach
      </div>
   </div>
</div>

<style>
   .marquee-wrapper {
      background: white;
   }

   .marquee-track {
      display: flex;
      width: max-content;
      animation: marquee-scroll 60s linear infinite;
   }

   .marquee-track:hover {
      animation-play-state: paused;
   }

   .marquee-content {
      display: flex;
      align-items: center;
      gap: 0;
   }

   .marquee-item {
      display: inline-flex;
      align-items: center;
      gap: 24px;
      padding: 0 0 0 32px;
      white-space: nowrap;
   }

   .marquee-asterisk {
      font-size: 28px;
      color: #000000;
      line-height: 1;
      display: inline-block;
      animation: spin-slow 6s linear infinite;
   }

   .marquee-track:hover .marquee-asterisk {
      animation-play-state: paused;
   }

   .marquee-text {
      font-family: 'DM Serif Display', 'Georgia', serif;
      font-size: clamp(40px, 5vw, 72px);
      font-weight: 400;
      font-style: normal;
      line-height: 1;
      text-transform: capitalize;

      /* Webkit outline text style */
      color: transparent;
      -webkit-text-stroke: 1.5px rgba(0, 0, 0, 0.25);
      -webkit-text-fill-color: transparent;

      letter-spacing: 0.01em;
      cursor: default;
      transition: -webkit-text-stroke 0.3s ease, -webkit-text-fill-color 0.3s ease;
      user-select: none;
   }

   .marquee-item:hover .marquee-text {
      -webkit-text-stroke: 1.5px rgba(0, 0, 0, 0.7);
   }

   @keyframes marquee-scroll {
      0% {
         transform: translateX(0);
      }

      100% {
         transform: translateX(-50%);
      }
   }

   @keyframes spin-slow {
      from {
         transform: rotate(0deg);
      }

      to {
         transform: rotate(360deg);
      }
   }
</style>