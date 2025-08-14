<x-app-layout>
   <div>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
            <div class="container mx-auto px-6 py-1 pb-16">
              <div class="bg-white shadow-md rounded my-6 p-5">
                <form method="POST" action="{{ route('admin.posts.store') }}">
                  @csrf
                  <div class="flex flex-col space-y-2">
                    <label for="title" class="text-gray-700 select-none font-medium">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                      placeholder="Enter title" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    />
                </div>
        
                <div class="flex flex-col space-y-2">
                    <label for="description" class="text-gray-700 select-none font-medium">Description</label>
                    <textarea name="description" id="description" placeholder="Enter description" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200" rows="5">{{ old('description') }}</textarea>
                </div>
    
                <h3 class="text-xl my-4 text-gray-600">Status</h3>
                <div class="grid grid-cols-3 gap-4">
                  <div class="relative inline-flex">
                    
                    <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="publish">
                      <option value="0">Draft</option>
                      <option value="1">Publish</option>
                    </select>
                  </div>
                </div>
                <div class="text-center mt-16 mb-16">
                  <button type="submit" class="bg-blue-500 text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors ">Submit</button>
                </div>
              </div>

             
            </div>
        </main>
    </div>
</div>
</x-app-layout>
