<script src="{{ asset('js/punch_begin.js') }}" defer></script>
<div class="col-span-12 grid grid-cols-12">
    <input type="checkbox" id="punch_begin_type" name="punch_begin_type" class="peer hidden" {{ $default == "早出" ? 'checked' : '' }}>
    <label for="punch_begin_type" id="punch_begin_type_label" class="bg-gray-200 select-none cursor-pointer rounded-lg border-2 border-black py-8 px-6 transition-colors duration-200 ease-in-out peer-checked:bg-blue-200 col-span-2 text-center text-3xl">{{ $default }}</label>
</div>