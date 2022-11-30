<x-app-layout>
  <div>
       <main>
           <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
             

               <form method="POST" action="{{ route('admin.hospitals.update',$hospital->id)}}" enctype="multipart/form-data">
                @csrf
                @method('put')

                <p class="h3 text-danger"><strong><em>Update Hospital<span class="text-success"> Configurations</span></em></strong></p>
               <hr />
                 <div class="row pt-5 pb-4">

                   <div class="col-md-4">
                     <label for="title" class="text-gray-700 font-black mr-2">Title</label>
                     <input id="title" type="text" name="title" value="{{ old('title',$hospital->title) }}" class="form-control" />
                   </div>
                   <div class="col-md-4">
                     <label for="logo" class="text-gray-700 font-black">Logo:</label>
                     <input id="logo" type="file" name="logo" value="{{ old('logo',$hospital->logo) }}" class="form-control" required/>
                   </div>
                   <div class="col-md-4">
                     <label for="phc_no" class="text-gray-700 font-black">PHC No:</label>
                     <input id="phc_no" type="number" name="phc_no" value="{{ old('phc_no',$hospital->phc_no) }}" class="form-control" />
                   </div>

                 </div>
                
                 <div class="row mt-4">

                  <div class="col-md-4">
                    <label for="contact" class="text-gray-700 font-black">Contact Number</label>
                    <input type="tel" id="contact" name="contact" placeholder="XXXXXXXXXXX" pattern="[0-9]{4}[0-9]{7}" value="{{ old('contact',$hospital->contact) }}" class="form-control" required>
                  </div>
                
                  <div class="col-md-4">
                    <label for="email" class="text-gray-700 font-black">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email',$hospital->email) }}" placeholder="Please enter your email address" class="form-control" />
                  </div>

                  <div class="col-md-4">
                    <label for="website" class="text-gray-700 font-black">Website</label>
                    <input type="text" id="website" name="website" value="{{ old('website', $hospital->website) }}" class="form-control" />
                  </div>

                 </div>

                 <div class="row mt-4">

                   <div class="col-md-12">
                     <label for="address" class="text-gray-700 font-black">Address</label>
                     <textarea name="address" id="address" placeholder="Enter address" class="form-control" rows="5">{{ old('address',$hospital->address) }}</textarea>
                   </div>

                 </div>

                 <div class="row mt-4">

                   <div class="col-md-12">
                     <label for="remarks" class="text-gray-700 font-black">Remarks</label>
                     <span class="ml-2 text-xs text-danger font-italic"> *Only 255 characters allowed </span>
                     <textarea name="remarks" id="remarks" placeholder="Enter Remarks" class="form-control" rows="5">{{ old('remarks',$hospital->remarks) }}</textarea>
                     <h6 class="float-end text-primary mx-1 my-2" id="count_message"></h6>
                   </div>

                 </div>
                 
                 <div class="row mt-5">

                   <div class="col-md-12 text-center">
                     <a class="btn btn-warning text-primary mx-2" accesskey="b" href="{{ route('admin.hospitals.index')}}" role="button"><u>B</u>ack</a>
                     <button type="submit" class="btn btn-success mx-2">Submit</button>
                   </div>

                 </div>

               </form> 
           </div>
       </main>
   </div>
</div>

@section('script')
<script>
  var text_max = 255;
  $('#count_message').html(text_max + ' remaining');
    $('#remarks').keyup(function() {
    var text_length = $('#remarks').val().length;
    var text_remaining = text_max - text_length;
    $('#count_message').html(text_remaining + ' remaining');
  }); 
</script>
@stop

</x-app-layout>
