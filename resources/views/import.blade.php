@extends('template')

@section('styles')
<style>
    .mb-2{margin-bottom:.5rem}
    .mb-4{margin-bottom:1rem}
    .mb-8{margin-bottom:2rem}

    .my-2{margin-bottom:.5rem;margin-top:.5rem}
    .my-4{margin-bottom:1rem;margin-top:1rem}
    .my-8{margin-bottom:2rem;margin-top:2rem}

    .submit-button { padding: .5rem 1rem; background: transparent; border: 1px solid; border-radius: 5px; letter-spacing: 1px; }
    .submit-button:hover { background: #000; color: #fff; }

    .form-control { border: 1px solid #ddd; border-radius: 10px; display: block; float: none; padding: .75rem;}
    .error { letter-spacing: .5px; color: #dc3545; font-weight: 600; }
    .success { letter-spacing: .5px; color: #28a745; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="p-6">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg leading-7 font-semibold"><a href="javascript://" class="underline text-gray-900 dark:text-white">Import a file</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                @if (\Illuminate\Support\Facades\Session::has('errors'))
                    <div class="errors error">
                        <ul>
                            @foreach (\Illuminate\Support\Facades\Session::get('errors') as $error)
                                <li>{!! $error[0] !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (\Illuminate\Support\Facades\Session::has('success'))
                    <div class="success">
                        {!! \Illuminate\Support\Facades\Session::get('success') !!}
                    </div>
                @endif


                Import excel file into the database <br>
                <form action="{!! route('import.submit') !!}" method="post" enctype="multipart/form-data" id="importForm" class="form-horizontal import-form">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" id="file" class="form-control" />
                    </div>
                    <br />
                    <button type="submit" class="my-2 submit-button">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <div class="ml-4 text-lg leading-7 font-semibold"><a href="{!! route('welcome') !!}" class="underline text-gray-900 dark:text-white">Back to home page</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <ul>
                    <li>Refer this <a href="{{asset('sample/mcq_import.xlsx')}}" target="_blank" style="text-decoration: underline" >Sample</a> file for import</li>
                    <li>Import file should be XLS or XLSX with a sheet into it</li>
                    <li>Although, you can format text into cells, but you should follow same format as mentioned into sample file.</li>
                </ul>
                {{-- <a target="_blank" href="{{asset('sample/mcq_import.xlsx')}}">Download Sample</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{!! asset('scripts/jquery.min.js') !!}"></script>
<script src="{!! asset('scripts/extensions/validation/jquery.validate.min.js') !!}"></script>
<script src="{!! asset('scripts/extensions/validation/additional-methods.min.js') !!}"></script>

<script>
    $('#importForm').validate({
        rules: {
            file: {
                required: true,
                extension: 'xls|xlsx'
            }
        },
        messages: {
            file: {
                required: 'Please select import file',
                extension: 'Import file should be an excel file.'
            }
        }
    });
</script>
@endsection
