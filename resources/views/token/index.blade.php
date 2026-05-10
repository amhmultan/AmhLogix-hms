<x-app-layout>
    <main>
        <div class="container-fluid py-4 px-5">
  
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
                      <th class="py-3 px-4 border text-center">PRESCRIPTION</th>
                      <th class="py-3 px-4 border text-center">Token ID</th>
                      <th class="py-3 px-4 border text-center">MR NO.</th>
                      <th class="py-3 px-4 border text-center">PATIENT NAME</th>
                      <th class="py-3 px-4 border text-center">DOCTORS NAME</th>
                      <th class="py-3 px-4 border text-center">SPECIALTY</th>
                      <th class="py-3 px-4 border text-center">REFFERED BY</th>
                      <th class="py-3 px-4 border text-center">FEES</th>
                      <th class="py-3 px-4 border text-center">PAID</th>
                      <th class="py-3 px-4 border text-center">BALANCE</th>
                      <th class="py-3 px-4 border text-center">REGISTERED ON</th>
                      <th class="py-3 px-4 border text-center">UPDATED ON</th>
                      <th class="py-3 px-4 border text-center">ACTIONS</th>
                    </tr>
                  </thead>
                  <tbody>
                    @can('Token access')
                      @foreach($tokens as $token)
                        <tr class="text-center">
                          <td class="px-4 py-2 border">
                            @can('Token access')
                              <a href="{{route('admin.tokens.show',$token->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-green-400">Show</a>
                            @endcan
                          </td>
                          <td class="px-4 py-2 border">{{ $token->id }}</td>
                          <td class="px-4 py-2 border">{{ $token->fk_patients_id }}</td>
                          <td class="px-4 py-2 border">{{ $token->pName }}</td>
                          <td class="px-4 py-2 border">{{ $token->dName }}</td>
                          <td class="px-4 py-2 border">{{ $token->sTitle }}</td>
                          <td class="px-4 py-2 border">{{ $token->reffered_by }}</td>
                          <td class="px-4 py-2 border">{{ $token->fees }}</td>
                          <td class="px-4 py-2 border">{{ $token->denomination }}</td>
                          <td class="px-4 py-2 border">{{ $token->balance }}</td>
                          <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($token->created_at)->format('d-m-Y h:i A') }}</td>
                          <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($token->updated_at)->format('d-m-Y h:i A') }}</td>

                          <td class="px-4 py-2 border">
                            
                            @can('Token edit')
                            <a href="{{route('admin.tokens.edit',$token->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                            @endcan
        
                            @can('Token delete')
                            <form action="{{ route('admin.tokens.destroy', $token->id) }}" method="POST" class="inline">
                                @csrf
                                @method('delete')
                                <button class="text-decoration-none text-grey-lighter font-bold py-1 px-1 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
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
  </div>
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