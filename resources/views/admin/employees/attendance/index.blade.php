@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

<?php 

$monthList[] = __('msg.select').' '.__('msg.month');
foreach($month_options as $month){
   $monthList["value"] = $month['label'];
    /* dd($month['value']); */
}
$yearList[] = __('msg.select').' '.__('msg.year');
foreach($year_options as $year){
    dd($year);
   $yearList["value"] = $month['label'];
    /* dd($month['value']); */
}



?>

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <x-card variant="primary" outline="true" title="{!! __('msg.attendance_sheet').' '.__('msg.list') !!}">
                <x-slot name="body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="company_table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 15%">{{ __('msg.name') }}</th>
                                    <th class="text-center" style="width: 35%">{{ __('msg.information') }}</th>
                                    <th class="text-center" style="width:10%">{{ __('msg.status') }}</th>
                                    <th class="text-center" style="width: 20%">{{ __('msg.created_at') }}</th>
                                    <th style="text-align: right;width: 20%">{{ __('msg.action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </x-slot>
            </x-card>
        </div>
   
        <div class="col-sm-12 col-md-4">
            <x-form route="company.save" :update="$record->id ?? null">
                <x-slot name="body">
                    <x-card variant="primary"  title="{{__('msg.attendance_sheet').' '.__('msg.information')}}">
                        <x-slot name="body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            $attr = [
                                                'class'         =>  'form-control',
                                                'id'            =>  'year',
                                                'required'      =>  'required',
                                            ];
                                        ?>
                                        {!! Form::label('year', __('msg.year')) !!} <span class="text-danger">*</span>
                                        {!! Form::select('year',$yearList,$record->year ?? old('year'),$attr) !!}
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            $attr = [
                                                'class'         =>  'form-control',
                                                'id'            =>  'month',
                                                'required'      =>  'required',
                                            ];
                                        ?>
                                        {!! Form::label('month', __('msg.month')) !!} <span class="text-danger">*</span>
                                        {!! Form::select('month',$monthList,$record->month ?? old('month'),$attr) !!}
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <?php
                                    $attr = [
                                        'class'         =>  'form-control',
                                        'id'            =>  'designation',
                                        'required'      =>  'required',
                                    ];
                                ?>
                                {!! Form::label('designation', __('msg.designation')) !!} <span class="text-danger">*</span>
                                {!! Form::select('designation',$designationList,$record->designation_id ?? old('designation'),$attr) !!}
                            </div> --}}
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('dob',__('msg.dob')) !!}<span class="text-danger">*</span>
                                        <?php
                                            $attr = [
                                                'class'         =>  'form-control',
                                                'readonly'      =>  'readonly',
                                                'id'            =>  'date_of_birth',
                                            ];
                                        ?>
                                        {!! Form::text('dob',$record->dob ?? old('dob'),$attr) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('dob',__('msg.dob')) !!}<span class="text-danger">*</span>
                                        <?php
                                            $attr = [
                                                'class'         =>  'form-control',
                                                'readonly'      =>  'readonly',
                                                'id'            =>  'date_of_birth',
                                            ];
                                        ?>
                                        {!! Form::text('dob',$record->dob ?? old('dob'),$attr) !!}
                                    </div>
                                </div>
                            </div>

                            

                            

                            
                            


                           

                            <x-slot name="footer">
                                {!! Form::submit(__('msg.save'),["class"=>"btn btn-success float-right"]) !!}
                            </x-slot>
                        </x-slot>
                    </x-card>
                </x-slot>
            </x-form>
        </div>
    </div>
@endsection


@section('js')
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    const address = $('#address');
    address.summernote({
        height     : 120,
        placeholder:'Dhaka,Bangladesh',
        toolbar: [
            ['style', ['bold']],
            ['font', [ 'fontname','fontsize']],
        ]
    });
</script>

<script>
    $(function() {
        window.LaravelDataTables=window.LaravelDataTables||{};
        window.LaravelDataTables["dataTableBuilder"]=$("#company_table").DataTable({
            "serverSide":true,
            "processing":true,
            "ajax":{
                "url" : '{{route('company.datatable')}}',
                "type": "GET"
            },
            "columns":[
                {data: 'name',"orderable":true,"searchable":true},
                {data: 'information',"orderable":false,"searchable":false},
                {data: 'deleted_at',"orderable":false,"searchable":false},
                {data: 'created_at',"orderable":false,"searchable":false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection