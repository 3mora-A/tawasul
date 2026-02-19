{{-- resources/views/communities/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<form
  id="communityForm"
  method="POST"
  action="{{ route('communities.update', $community) }}"
  enctype="multipart/form-data"
  {{-- class="max-w-2xl mx-auto bg-[#24273b] rounded-2xl shadow-xl overflow-hidden mt-10" --}}
>
  @csrf
  @method('PUT')

  {{-- Header --}}
  <div class="px-6 py-4 bg-[#1A1B23] border-b border-gray-700">
    <h2 class="text-2xl font-semibold text-white">Edit Community</h2>
  </div>

  {{-- Body --}}
  <div class="px-6 py-6 space-y-6 bg-[#2F3336]">
    {{-- Name --}}
    <div>
      <label for="name" class="block text-sm font-medium text-gray-200">Community Name</label>
      <input
        id="name"
        name="name"
        type="text"
        required
        value="{{ old('name', $community->name) }}"
        class="mt-1 w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Description --}}
    <div>
      <label for="description" class="block text-sm font-medium text-gray-200">Description</label>
      <textarea
        id="description"
        name="description"
        rows="4"
        class="mt-1 w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
      >{{ old('description', $community->description) }}</textarea>
      @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Banner Upload --}}
    <div>
      <label class="block text-sm font-medium text-gray-200 mb-1">Banner (optional)</label>
      <button
        id="banner-btn"
        type="button"
        class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded-md text-sm text-white"
      >Change Banner</button>
      <input
        id="banner-input"
        name="banner_path"
        type="file"
        accept="image/*"
        class="hidden"
      />
      <div
        id="banner-preview"
        class="mt-4 h-32 bg-gray-600 bg-cover bg-center rounded-md"
        style="background-image: url('{{ $community->banner_path ? asset('storage/'.$community->banner_path) : '' }}')"
      ></div>
      @error('banner_path')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Icon Upload --}}
    <div>
      <label class="block text-sm font-medium text-gray-200 mb-1">Icon (optional)</label>
      <button
        id="icon-btn"
        type="button"
        class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded-md text-sm text-white"
      >Change Icon</button>
      <input
        id="icon-input"
        name="icon_path"
        type="file"
        accept="image/*"
        class="hidden"
      />
      <div class="mt-4 flex items-center space-x-4">
        <div id="icon-preview" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-indigo-600 flex items-center justify-center">
          @if($community->icon_path)
            <img src="{{ asset('storage/'.$community->icon_path) }}" class="w-full h-full object-cover" />
          @else
            <svg viewBox="0 0 20 20" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" class="text-white">
              <circle cx="10" cy="10" r="10" fill="#6366F1"/>
              <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
                    font-size="10" fill="white" font-family="Arial, sans-serif" font-weight="bold">
                {{ strtoupper(substr($community->name,0,1)) }}
              </text>
            </svg>
          @endif
        </div>
        <div class="text-white">
          <div id="preview-icon-text" class="font-semibold">
            T/{{ $community->name }}
          </div>
          <div class="text-xs text-gray-400">{{ $community->members()->count() }} members · {{ $community->members()->count() }} online</div>
        </div>
      </div>
      @error('icon_path')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    </div>
  </div>

{{-- Footer --}}
<div class="px-6 py-4 bg-[#1A1B23] flex justify-between items-center">
  {{-- Delete on the left --}}
  @if(auth()->id() === $community->creator_id)
    <button
      type="submit"
      form="deleteCommunityForm"
      class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded"
    >
      Delete Community
    </button>
  @endif

  {{-- Cancel & Save on the right --}}
  <div class="flex space-x-2">
    <button
      href="{{ route('communities.show', $community) }}"
      class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded"
    >
      Cancel
    </button>
    <button
      type="submit"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded"
    >
      Save Changes
    </button>
  </div>
</div>

</form>

{{-- Hidden Delete Form --}}
<form
  id="deleteCommunityForm"
  action="{{ route('communities.destroy', $community) }}"
  method="POST"
  onsubmit="return confirm('Are you sure you want to delete this community?');"
  class="hidden"
>
  @csrf
  @method('DELETE')
</form>


<script>
window.addEventListener('DOMContentLoaded', () => {
  // Banner preview
  document.getElementById('banner-btn').onclick = () => document.getElementById('banner-input').click();
  document.getElementById('banner-input').onchange = e => {
    const f = e.target.files[0];
    if (f) {
      document.getElementById('banner-preview').style.backgroundImage = `url(${URL.createObjectURL(f)})`;
    }
  };

  // Icon preview
  const iconPreview = document.getElementById('icon-preview');
  document.getElementById('icon-btn').onclick = () => document.getElementById('icon-input').click();
  document.getElementById('icon-input').onchange = e => {
    const f = e.target.files[0];
    if (f) {
      iconPreview.innerHTML = '';
      const img = document.createElement('img');
      img.src = URL.createObjectURL(f);
      img.className = 'w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover border-4 border-[#2F3336] shadow';
      iconPreview.appendChild(img);
    }
  };

  // Live update icon text
  const nameIn = document.getElementById('name');
  const defaultIconLetter = document.getElementById('default-icon-letter');
  const previewIconText = document.getElementById('preview-icon-text');
  function updateIcon() {
    const nm = nameIn.value.trim();
    const first = nm.charAt(0).toUpperCase() || 'T';
    if (defaultIconLetter) defaultIconLetter.textContent = first;
    previewIconText.textContent = nm ? `T/${nm}` : 'T/';
  }
  nameIn.oninput = updateIcon;
});
</script>
@endsection
