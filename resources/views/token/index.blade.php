<x-app-layout>
  <main>
    <div class="container-fluid py-4">

          <div class="row mb-5">
            <div class="col-sm-6">
              <p class="h3 text-danger"><strong><em>Token <span class="text-success">Dashboard</span></em></strong></p>
            </div>
            <div class="col-sm-6 text-right">
              @can('Token add')
                <a href="{{route('admin.tokens.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Token</a>
              @endcan
            </div>
          </div>
        
        @if (!$tokens->isEmpty())
          <div class="table-responsive bg-white shadow-md rounded border-collapse p-3">
            <table id="tokenTable" class="table w-100 border-collapse">
              <thead>
                <tr class="bg-indigo-500 text-white">
                  <th class="py-2 px-2 border text-center">PRESCRIPTION</th>
                  <th class="py-2 px-2 border text-center">Token ID</th>
                  <th class="py-2 px-2 border text-center">MR NO.</th>
                  <th class="py-2 px-2 border text-center">PATIENT NAME</th>
                  <th class="py-2 px-2 border text-center">DOCTORS NAME</th>
                  <th class="py-2 px-2 border text-center">SPECIALTY</th>
                  <th class="py-2 px-2 border text-center">REFFERED BY</th>
                  <th class="py-2 px-2 border text-center">FEES</th>
                  <th class="py-2 px-2 border text-center">PAID</th>
                  <th class="py-2 px-2 border text-center">BALANCE</th>
                  <th class="py-2 px-2 border text-center">REGISTERED ON</th>
                  <th class="py-2 px-2 border text-center">UPDATED ON</th>
                  <th class="py-2 px-2 border text-center text-nowrap">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @can('Token access')
                  @foreach($tokens as $token)
                    <tr class="text-center">
                      <td class="px-2 py-2 border">
                        @can('Token access')
                          <a href="{{route('admin.tokens.show',$token->id)}}" class="btn btn-info btn-sm">Show</a>
                        @endcan
                      </td>
                      <td class="px-2 py-2 border">{{ $token->id }}</td>
                      <td class="px-2 py-2 border">{{ $token->fk_patients_id }}</td>
                      <td class="px-2 py-2 border">{{ $token->pName }}</td>
                      <td class="px-2 py-2 border">{{ $token->dName }}</td>
                      <td class="px-2 py-2 border">{{ $token->sTitle }}</td>
                      <td class="px-2 py-2 border">{{ $token->reffered_by }}</td>
                      <td class="px-2 py-2 border">{{ $token->fees }}</td>
                      <td class="px-2 py-2 border">{{ $token->denomination }}</td>
                      <td class="px-2 py-2 border">{{ $token->balance }}</td>
                      <td class="px-2 py-2 border">{{ \Carbon\Carbon::parse($token->created_at)->format('d-m-y h:i A') }}</td>
                      <td class="px-2 py-2 border">{{ \Carbon\Carbon::parse($token->updated_at)->format('d-m-y h:i A') }}</td>

                      <td class="px-2 py-2 border text-nowrap">
                        
                        @can('Token edit')
                        <a href="{{route('admin.tokens.edit',$token->id)}}" class="btn btn-primary btn-sm">Edit</a>
                        @endcan
    
                        @can('Token delete')
                        <form action="{{ route('admin.tokens.destroy', $token->id) }}" method="POST" class="inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endcan
                      </td>
                    </tr>
                  @endforeach
                  @endcan
              </tbody>
            </table>
          </div>
          
        @else

        <div class="row flex text-center mt-5 pt-5">
          <div class="col-sm-12">
            <h1 class="h4 italic text-danger">NO RECORD FOUND</h1>
          </div>
        </div>
      
      @endif

    </div>
  </main>

  @push('scripts')
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('#tokenTable').DataTable(
      {
        order: [[0, 'desc']],
      });
  } );
  </script>
  @endpush

  </x-app-layout>