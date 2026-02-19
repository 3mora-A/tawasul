{{-- resources/views/communities/create.blade.php --}}
@extends('layouts.app')

@section('content')
<form
  id="communityForm"
  method="POST"
  action="{{ route('communities.store') }}"
  enctype="multipart/form-data"
  class="bg-[#24273b]"
>
  @csrf

  <!-- Header -->
  <div class="px-6 py-4 border-b border-gray-700 bg-[#1A1B23]">
    <h2 id="modal-title" class="text-2xl font-semibold text-white">
      Tell us about your community
    </h2>
    <p id="modal-subtitle" class="mt-1 text-gray-400 text-sm">
      A name and description help people understand what your community is all about.
    </p>
  </div>

  <!-- Steps container -->
  <div class="relative bg-[#2F3336]">
    <!-- Step 1 -->
    <div id="step-1" class="px-6 py-6 space-y-6">
      <!-- Name -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-200">
          Community name <span class="text-red-500">*</span>
        </label>
        <input
          id="name"
          name="name"
          type="text"
          maxlength="21"
          required
          value="{{ old('name') }}"
          class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2
                 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
        />
        @error('name')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500 text-right">
          <span id="name-count">0</span>/21
        </p>
      </div>

      <!-- Description -->
      <div>
        <label for="description" class="block text-sm font-medium text-gray-200">
          Description <span class="text-red-500">*</span>
        </label>
        <textarea
          id="description"
          name="description"
          rows="4"
          required
          class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2
                 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
        >{{ old('description') }}</textarea>
        @error('description')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500 text-right">
          <span id="desc-count">0</span> characters
        </p>
      </div>

      <!-- Live Preview -->
      <div class="flex flex-col md:flex-row bg-gray-700 rounded-md overflow-hidden">
        <div class="flex-1 px-4 py-3">
          <div class="text-sm text-gray-400">
            T/<span id="preview-name">community name</span>
          </div>
          <div class="text-xs text-gray-500 mb-2">1 member · 1 online</div>
          <div class="text-sm text-gray-300" id="preview-desc">
            Your community description
          </div>
        </div>
      </div>
    </div>

    <!-- Step 2 -->
    <div id="step-2" class="hidden px-6 py-6 space-y-6">
      <!-- Banner upload -->
      




      <!-- Banner upload -->
      <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-200">Banner (optional)</span>
        <div>
          <button
            id="banner-btn"
            type="button"
            class="inline-flex items-center space-x-2 px-3 py-1 bg-gray-700 hover:bg-gray-600
                  rounded-md text-sm text-white"
          >
          <svg rpl="" fill="currentColor" height="20" icon-name="image-post-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"> <!--?lit$373681882$--><!--?lit$373681882$--><path d="M13 4a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm0 4.75a1.75 1.75 0 1 1 0-3.5 1.75 1.75 0 0 1 0 3.5Z"></path><path d="M17.375 1H2.625A1.627 1.627 0 0 0 1 2.625v14.75A1.627 1.627 0 0 0 2.625 19h14.75A1.627 1.627 0 0 0 19 17.375V2.625A1.627 1.627 0 0 0 17.375 1ZM2.25 17.375v-2.683L4.9 12.04a2.332 2.332 0 0 1 3.3 0l5.71 5.71H2.625a.375.375 0 0 1-.375-.375Zm15.5 0a.375.375 0 0 1-.375.375h-1.7l-6.6-6.594a3.582 3.582 0 0 0-5.063 0L2.25 12.925v-10.3a.375.375 0 0 1 .375-.375h14.75a.375.375 0 0 1 .375.375v14.75Z"></path><!--?--> </svg>          
          <span>Add</span>
            
          </button>

          <!-- only one file input, named "image" to match your validation -->
          <input
            id="banner-input"
            name="banner_path"
            type="file"
            accept="image/*"
            class="hidden"


          />
        </div>
      </div>


      <!-- Icon upload -->
      <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-200">Icon (optional)</span>
        <div>
          <button
            id="icon-btn"
            type="button"
            class="inline-flex items-center space-x-2 px-3 py-1 bg-gray-700 hover:bg-gray-600
                  rounded-md text-sm text-white"
          >
            <svg fill="currentColor" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
              <path d="M13 4a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm0 4.75a1.75 1.75 0 1 1 0-3.5 1.75 1.75 0 0 1 0 3.5Z"/>
              <path d="M17.375 1H2.625A1.627 1.627 0 0 0 1 2.625v14.75A1.627 1.627 0 0 0 2.625 19h14.75A1.627 1.627 0 0 0 19 17.375V2.625A1.627 1.627 0 0 0 17.375 1ZM2.25 17.375v-2.683L4.9 12.04a2.332 2.332 0 0 1 3.3 0l5.71 5.71H2.625a.375.375 0 0 1-.375-.375Zm15.5 0a.375.375 0 0 1-.375.375h-1.7l-6.6-6.594a3.582 3.582 0 0 0-5.063 0L2.25 12.925v-10.3a.375.375 0 0 1 .375-.375h14.75a.375.375 0 0 1 .375.375v14.75Z"/>
            </svg>
            <span>Add</span>
          </button>

          <!-- Single file input, name matches your controller’s 'icon' rule -->
          <input
            id="icon-input"
            name="icon_path"
            type="file"
            accept="image/*"
            class="hidden"

          />
        </div>
      </div>


       <!-- Previews -->
<div class="space-y-6">
  <div
    id="banner-preview"
    class="h-32 bg-gray-600 bg-cover bg-center rounded-md"
  ></div>

  <div class="flex items-center">
    <!-- now a single class -->
    <div id="icon-preview" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-indigo-600 flex items-center justify-center">
      <svg
        viewBox="0 0 20 20"
        width="100%"
        height="100%"
        xmlns="http://www.w3.org/2000/svg"
      >
        <circle cx="10" cy="10" r="10" fill="#6366F1" />
        <text
          id="default-icon-letter"
          x="50%"
          y="50%"
          text-anchor="middle"
          dominant-baseline="middle"
          font-size="10"
          fill="white"
          font-family="Arial, sans-serif"
          font-weight="bold"
        >
          T
        </text>
      </svg>
    </div>
    

    <div class="ml-3 text-white">
      <div id="preview-icon-text" class="font-semibold">T/</div>
      <div class="text-xs text-gray-400">1 member · 1 online</div>
    </div>
  </div>
</div>

    </div>
  </div>

  <!-- Footer -->
  <div class="px-6 py-4 flex items-center justify-between border-t border-gray-700 bg-[#1A1B23]">
    <!-- Dots -->
    <div class="flex space-x-1">
      <span id="dot-1" class="w-2 h-2 bg-blue-500 rounded-full"></span>
      <span id="dot-2" class="w-2 h-2 bg-gray-600 rounded-full"></span>
    </div>
    <!-- Buttons -->
    <div class="space-x-2">
      <button
        id="back-btn"
        type="button"
        class="px-4 py-2 bg-gray-600 hover:bg-gray-500 rounded-md text-sm text-white"
        disabled
      >
        Back
      </button>
      <button
        id="next-btn"
        type="button"
        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-md text-sm text-white"
      >
        Next
      </button>
    </div>
  </div>
</form>

<script>
  window.addEventListener('DOMContentLoaded', () => {
  // Wizard elements
  const form        = document.getElementById('communityForm');
  const steps       = {1: document.getElementById('step-1'), 2: document.getElementById('step-2')};
  const dots        = {1: document.getElementById('dot-1'), 2: document.getElementById('dot-2')};
  const backBtn     = document.getElementById('back-btn');
  const nextBtn     = document.getElementById('next-btn');

  // Step 1 inputs & previews
  const nameIn      = document.getElementById('name');
  const descIn      = document.getElementById('description');
  const nameCnt     = document.getElementById('name-count');
  const descCnt     = document.getElementById('desc-count');
  const prevName    = document.getElementById('preview-name');
  const prevDesc    = document.getElementById('preview-desc');

  // Step 2 banner & icon
  const bannerBtn   = document.getElementById('banner-btn');
  const bannerInput = document.getElementById('banner-input');
  const bannerPrev  = document.getElementById('banner-preview');
  const iconBtn     = document.getElementById('icon-btn');
  const iconInput   = document.getElementById('icon-input');
  const iconPrev    = document.getElementById('icon-preview');

  // SVG letter & “T/…” text
  let defaultIconSVG   = iconPrev.innerHTML;
  const defaultIconLetter = document.getElementById('default-icon-letter');
  const previewIconText   = document.getElementById('preview-icon-text');

  let current = 1, total = 2;

  function showStep(n) {
    current = Math.max(1, Math.min(total, n));
    for (let i = 1; i <= total; i++) {
      steps[i].classList.toggle('hidden', i !== current);
      dots[i].classList.toggle('bg-blue-500', i === current);
      dots[i].classList.toggle('bg-gray-600', i !== current);
    }
    backBtn.disabled = current === 1;
    nextBtn.textContent = current === total ? 'Create' : 'Next';
  }

  function updatePreview() {
    const nm  = nameIn.value.trim();
    const dc  = descIn.value.trim();
    const first = nm.charAt(0).toUpperCase() || 'T';

    // Step 1 live‐preview
    nameCnt.textContent = nm.length;
    descCnt.textContent = dc.length;
    prevName.textContent = nm || 'communityname';
    prevDesc.textContent = dc || 'Your community description';

    // Step 2 icon letter + “T/…” text
    defaultIconLetter.textContent = first;
    previewIconText.textContent   = nm ? `T/${nm}` : 'T/';
  }

  // Handlers
  backBtn.addEventListener('click', () => showStep(current - 1));
  nextBtn.addEventListener('click', () => {
    if (current === 1 && !nameIn.value.trim()) {
      alert('Community name is required.');
      return;
    }
    if (current === total) {
      form.submit();
    } else {
      showStep(current + 1);
    }
  });

  nameIn.addEventListener('input', updatePreview);
  descIn.addEventListener('input', updatePreview);

  bannerBtn.addEventListener('click', () => bannerInput.click());
  bannerInput.addEventListener('change', e => {
    const f = e.target.files[0];
    if (f) bannerPrev.style.backgroundImage = `url(${URL.createObjectURL(f)})`;
  });

  iconBtn.addEventListener('click', () => iconInput.click());
  iconInput.addEventListener('change', e => {
    const f = e.target.files[0];
    if (f) {
      // replace SVG with user image
      iconPrev.innerHTML = '';
      const img = document.createElement('img');
      img.src       = URL.createObjectURL(f);
      img.className = 'w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover ';
      iconPrev.appendChild(img);
    } else {
      // restore default SVG
      iconPrev.innerHTML = defaultIconSVG;
      // re-cache the letter node if needed
      // defaultIconLetter = document.getElementById('default-icon-letter');
    }
  });

  // Initialize
  showStep(1);
  updatePreview();
});

  </script>
  
  
@endsection
