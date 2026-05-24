<x-app-layout>
    <main>
        <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
            <form method="POST" action="{{ route('admin.dosages.store') }}" enctype="multipart/form-data">
                @csrf

                <p class="h3 text-danger"><strong><em>Add <span class="text-success">Dosage</span></em></strong></p>
                <hr />
                <div class="row my-3">

                    <div class="col-md-4">
                        <label for="name" class="text-gray-700 font-black">Dosage Title:</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" />
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="text-gray-700 font-black">Status:</label>
                        <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="status">
                            <option value="0">Active</option>
                            <option value="1">Deactive</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                      <label for="description" class="text-gray-700 font-black">Description</label>
                      <span class="ml-2 text-xs text-danger font-italic"> *Only 255 characters allowed </span>
                      <textarea name="description" id="description" placeholder="Enter Description" class="form-control" rows="5">{{ old('description') }}</textarea>
                      <h6 class="float-end text-primary mx-1 my-2" id="count_message"></h6>
                    </div>
                </div>

                <div class="row my-3">

                    <div class="col-md-12 text-center">
                        <a class="btn btn-info mx-2" href="{{ route('admin.dosages.index')}}" accesskey="b" role="button"><u>B</u>ack</a>
                        <button type="submit" class="btn btn-success mx-2">Submit</button>
                    </div>

                </div>

            </form>
        </div>
    </main>

    @section('script')
    <script>
        var text_max = 255;
        $('#count_message').html(text_max + ' remaining');
        $('#description').keyup(function() {
            var text_length = $('#description').val().length;
            var text_remaining = text_max - text_length;
            $('#count_message').html(text_remaining + ' remaining');
        });
    </script>
    @stop

</x-app-layout>