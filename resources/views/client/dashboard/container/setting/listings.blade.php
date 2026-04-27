@extends('layouts.user')

@section('title', $title ?? 'Default Title')

@section('content')
  <div>
    <div class="w-full flex items-center justify-between gap-4 border-b border-black/15 dark:border-gray-700 pb-3">
      <div class="flex flex-col">
        <h1 class="text-4xl font-bold ">Edit Setting</h1>
        <p class="paragraph font-normal ">Edit Setting.</p>
      </div>
    </div>
    <form action={{ route('client.dashboard.container.setting.update', $user->id) }} method="post"
      class="w-full flex flex-col gap-5 py-8" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <div class="flex flex-col gap-1.5">
        <label for="name">
          <p class="paragraph font-normal ">Name</p>
        </label>
        <input id="name" name="name" value="{{ $user->name }}"
          class="w-full outline-none focus:border-black/50 px-3 py-1.5 paragraph bg-white dark:bg-black font-normal rounded-lg border border-black/10 dark:border-gray-700 shadow-[0_0_1px_rgba(0,0,0,0.2)]"
          placeholder="Name" type="text" />
      </div>
      <div class="flex flex-col gap-1.5">
        <label for="email">
          <p class="paragraph font-normal ">Email</p>
        </label>
        <input id="email" name="email" value="{{ $user->email }}"
          class="w-full outline-none focus:border-black/50 px-3 py-1.5 paragraph bg-white dark:bg-black font-normal rounded-lg border border-black/10 dark:border-gray-700 shadow-[0_0_1px_rgba(0,0,0,0.2)]"
          placeholder="Email">
      </div>
      <div class="flex flex-col gap-1.5">
        <label for="image">
          <p class="paragraph font-normal ">Image</p>
        </label>
        <input id="image" name="image" accept="image/*"
          class="w-full outline-none focus:border-black/50 px-3 py-1.5 paragraph bg-white dark:bg-black font-normal rounded-lg border border-black/10 dark:border-gray-700 shadow-[0_0_1px_rgba(0,0,0,0.2)]"
          type="file" onchange="previewImage(event)">
        <img id="userImagePreview"
          src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/placeholder.png') }}" alt="Preview"
          class="mt-2 w-40 rounded-lg">
      </div>
      <div
        class="w-fit flex items-center gap-2 bg-black px-5 py-3 rounded-lg border border-black/10 dark:border-gray-700">
        <button type="submit" class="text-white paragraph font-normal ">Update</button>
      </div>
    </form>
    <div class="w-full flex items-center justify-between gap-4 border-b border-black/15 dark:border-gray-700 pb-3">
      <div class="flex flex-col">
        <h1 class="text-4xl font-bold ">Change Password</h1>
      </div>
    </div>
    <form action={{ route('client.dashboard.container.setting.update', $user->id) }} method="post"
      class="w-full flex flex-col gap-5 py-8" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <div class="flex flex-col gap-1.5">
        <label for="current_password">
          <p class="paragraph font-normal ">Current Password</p>
        </label>
        <input id="current_password" name="current_password" type="password"
          class="w-full outline-none focus:border-black/50 px-3 py-1.5 paragraph bg-white dark:bg-black font-normal rounded-lg border border-black/10 dark:border-gray-700 shadow-[0_0_1px_rgba(0,0,0,0.2)]"
          placeholder="Enter current password">
        @error('current_password')
          <span class="text-red-500 paragraph">{{ $message }}</span>
        @enderror
      </div>
      <div class="flex flex-col gap-1.5">
        <label for="password">
          <p class="paragraph font-normal ">New Password</p>
        </label>
        <input id="password" name="password" type="password"
          class="w-full outline-none focus:border-black/50 px-3 py-1.5 paragraph bg-white dark:bg-black font-normal rounded-lg border border-black/10 dark:border-gray-700 shadow-[0_0_1px_rgba(0,0,0,0.2)]"
          placeholder="Enter new password">
        @error('password')
          <span class="text-red-500 paragraph">{{ $message }}</span>
        @enderror
      </div>
      <div class="flex flex-col gap-1.5">
        <label for="password_confirmation">
          <p class="paragraph font-normal ">Confirm Password</p>
        </label>
        <input id="password_confirmation" name="password_confirmation" type="password"
          class="w-full outline-none focus:border-black/50 px-3 py-1.5 paragraph bg-white dark:bg-black font-normal rounded-lg border border-black/10 dark:border-gray-700 shadow-[0_0_1px_rgba(0,0,0,0.2)]"
          placeholder="Confirm new password">
      </div>
      <div
        class="w-fit flex items-center gap-2 bg-black px-5 py-3 rounded-lg border border-black/10 dark:border-gray-700">
        <button type="submit" class="text-white paragraph font-normal ">Update</button>
      </div>
    </form>
  </div>

  <script>
    function previewImage(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('userImagePreview');
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = "{{ $user->image ? asset('storage/' . $user->image) : asset('assets/placeholder.png') }}";
      }
    }
  </script>

@endsection