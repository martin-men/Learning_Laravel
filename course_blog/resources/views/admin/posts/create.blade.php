<x-layout-blade-component>
    <x-slot name="content">
        <x-setting heading='Publish new post'>
            <form action="/admin/posts" method="post" enctype="multipart/form-data">
                @csrf
    
                <x-form.input name='title' />
                <x-form.input name='slug' />
                <x-form.input name='thumbnail' type='file' />
                <x-form.textarea name='excerpt' />
                <x-form.textarea name='body' />
                <x-form.field>
                    <x-form.label name='category' />
                    <select class="border border-gray-400 p-2 w-full" name="category_id" id="category" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                    <x-form.error name='category' />
                </x-form.field>
                <x-form.button>Publish</x-form.button>
            </form>
        </x-setting>
    </x-slot>
</x-layout-blade-component>
