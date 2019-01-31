@extends('layouts.app')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">   
        <div class="modal-dialog modal-dialog-centered center" role="document" style="width: 80% !important;max-width: 80% !important;min-width: 80% !important;">            
            <img src="" style="max-height:500px;min-height:100px;max-width:70%;" alt="currentImage">            
        </div>
    </div> 

    <section>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            <br>
        @endif
        @if (session('fail'))
            <div class="alert alert-warning" role="alert">
                {{ session('fail') }}
            </div>
            <br>
        @endif
        <div class="m-auto w-50">
            <p><small class="text-muted">Cargue sus archivos de imagen o video a Blion Aquí</small></p>            
            <form action="{{route('user.contents.store',$user_id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3">
                    <input type="file" name="mediafile">
                    <br>
                    {!! $errors->first('mediafile','<span class=error>:message</span>') !!}
                </div> 
                <input type="submit" value="Cargar" class="btn btn-block btn-primary">
            </form>
        </div>
        <hr>
        <h1 class="text-center">Mis Contenidos</h1>
        <div class="w-100 text-center">
            @foreach ($media_images as $image)
                <figure style="width:300px;overflow:hidden;" class="d-inline-block text-center bg-dark border position-relative figure-modal">
                    <img src="{{Storage::url($image->media_path)}}" style="height:210px;">

                    <div style="width:100%;height:100%;position: absolute;top:0;left:0;">
                        <form method="POST" action="{{route('user.contents.destroy',$image->id)}}" class="float-right">
                            @csrf
                            {!!method_field('DELETE')!!}
                            <button type="submit" class="btn btn-danger btn-xs">X</button>
                        </form>
                    </div>

                </figure>    
            @endforeach
            @foreach ($media_videos as $video)
                <figure style="width:300px;height:212px;overflow:hidden;" class="d-inline-block text-center bg-dark border position-relative">
                    

                    <div style="width:100%;height:40px;position: absolute;top:0;left:0;">                        
                        <form method="POST" action="{{route('user.contents.destroy',$video->id)}}" class="float-right">
                            @csrf
                            {!!method_field('DELETE')!!}
                            <button type="submit" class="btn btn-danger btn-xs">X</button>
                        </form>                        
                    </div>
                    
                    <video controls src="{{Storage::url($video->media_path)}}" style="height:210px;">
     
                </figure>    
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function config(){
            $("figure.figure-modal").on('click',function(){
                $("#exampleModal > div.modal-dialog > img").attr("src",this.children[0].src);
                $("#exampleModal").modal('show');                    
            });
            $("button[type=submit]").on('click',function(e){
                e.stopPropagation();
            })
        }



        window.addEventListener("load", config,false);
    </script>
@endsection