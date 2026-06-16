<div class="w-full padding-x padding-y bg-white">
   <div class="w-full flex flex-col gap-10">
      <div class="w-full flex flex-col items-center gap-3">
         <div class="bg-[#F0BB4C] rounded-full px-5 py-2.5">
            <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
               Frequently Asked Questions
            </p>
         </div>
         <h2 class="heading text-black font-semibold dmserif leading-tight max-w-4xl tracking-wide text-center">
            Help Center Got A Question? Get Your <span class="relative inline-block">
               Answers
               <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 120 20" fill="none">
                  <path d="M5 15C30 5 90 5 115 15" stroke="#F0BB4C" stroke-width="2" stroke-linecap="round" />
               </svg>
            </span>
         </h2>
      </div>
      <div class="w-full max-w-5xl mx-auto space-y-4">

         @php
         $faqs = [
         [
         "q" => "What services do you offer at your elderly home?",
         "a" => "Our goal is to create a safe comfortable and welcoming environment where seniors can enjoy their days
         with dignity purpose and a strong sense of experienced caregivers tailored support plans and engaging daily
         activities"
         ],
         [
         "q" => "Is medical care available on-site?",
         "a" => "Yes, we have trained medical staff available 24/7 along with regular doctor visits."
         ],
         [
         "q" => "How do I know if it’s the right time for senior care?",
         "a" => "If daily tasks become difficult or medical needs increase, it may be time to consider senior care."
         ],
         [
         "q" => "Can residents personalize their rooms?",
         "a" => "Yes, residents are encouraged to bring personal belongings to feel at home."
         ],
         [
         "q" => "What is the process for admission?",
         "a" => "Contact us, schedule a visit, complete assessment, and finalize admission paperwork."
         ],
         [
         "q" => "How much does it cost to stay at your facility?",
         "a" => "Costs vary based on services required. Please contact us for detailed pricing."
         ],
         ];
         @endphp

         @foreach ($faqs as $index => $faq)
         <div class="border rounded-xl bg-white">
            <button onclick="toggleFAQ({{ $index }})"
               class="w-full flex items-center justify-between p-5 text-left font-medium">

               <span>{{ $faq['q'] }}</span>

               <span id="icon-{{ $index }}"
                  class="w-8 h-8 flex items-center justify-center bg-[#F0BB4C] rounded-full text-black">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                     <path d="M12 5l0 14" />
                     <path d="M5 12l14 0" />
                  </svg>
               </span>
            </button>
            <div id="faq-{{ $index }}" class="hidden px-5 pb-5 text-[#666666]">
               {{ $faq['a'] }}
            </div>

         </div>
         @endforeach

      </div>
   </div>
</div>

<script>
function toggleFAQ(index) {
   const content = document.getElementById('faq-' + index);
   const icon = document.getElementById('icon-' + index);

   if (content.classList.contains('hidden')) {
      content.classList.remove('hidden');
      icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-minus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                     </svg>`;
   } else {
      content.classList.add('hidden');
      icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                     </svg>`;
   }
}
</script>