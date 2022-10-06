<x-app-layout>
    <main>
        <div class="container-fluid py-4 px-5">
  
              <div class="row mb-4">
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
  
            <table id="tokenTable" class="display table-responsive bg-white shadow-md rounded mt-5 text-left border-collapse">
              <thead>
                <tr>
                  <th class="py-3 px-5 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">Token ID</th>
                  <th class="py-3 px-5 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">MR NO.</th>
                  <th class="py-3 px-5 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">PATIENT NAME</th>
                  <th class="py-3 px-4 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">FEES</th>
                  <th class="py-3 px-4 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">PAID</th>
                  <th class="py-3 px-4 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">BALANCE</th>
                  <th class="py-3 px-4 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">REGISTERED ON</th>
                  <th class="py-3 px-4 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">UPDATED ON</th>
                  <th class="py-3 px-4 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @can('Token access')
                  @foreach($tokens as $token)
                    <tr>
                      <td class="text-nowrap text-xs px-4 text-center border-grey-light">{{ $token->id }}</td>
                      <td class="text-nowrap text-xs px-4 text-center border-grey-light">{{ $token->fk_patients_id }}</td>
                      <td class="text-nowrap text-xs px-4 text-center border-grey-light">{{ $token->name }}</td>
                      <td class="text-nowrap text-xs px-4 text-center border-grey-light">{{ $token->fees }}</td>
                      <td class="text-nowrap text-xs px-4 text-center border-grey-light">{{ $token->denomination }}</td>
                      <td class="text-nowrap text-xs px-4 text-center border-grey-light">{{ $token->balance }}</td>
                      <td class="text-nowrap text-xs px-4 border-grey-light">{{ $token->created_at }}</td>
                      <td class="text-nowrap text-xs px-4 border-grey-light">{{ $token->updated_at }}</td>
                      
                      
                      <td class="text-nowrap text-xs px-3 border-grey-light">
                        @can('Token access')
                          <a href="{{route('admin.tokens.show',$token->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-green-400">Show</a>
                        @endcan
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
  @section('script')
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('#tokenTable').DataTable();
  } );
  </script>
  @stop
  </x-app-layout>