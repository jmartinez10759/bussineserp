<?php
namespace App\Facades;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Maatwebsite\Excel\Facades\Excel;

class Upload extends Facade
{
    public  $directorio  = "upload_file/catalogos/";
    public  $carpeta     = "";
    public  $datos_excel = [];
    public  $table_model;
  /**
   * Metodo para subir los archivos al servidor.
   * @param Request $request [Description]
   * @return array [Description]
   */
    public function upload_file( Request $request ){
      ini_set('memory_limit', '-1');
      set_time_limit(0);
      $files = $request->file;
      try {
        for ($i=0; $i < count( $files ) ; $i++) {
            $archivo      	= file_get_contents($files[$i]);
            $name_temp    	= $files[$i]->getClientOriginalName();
            $ext      		  = strtolower($files[$i]->getClientOriginalExtension());
            $type 			    = $files[$i]->getMimeType();
            $tipo = explode('/', $type);
            #$dir = dirname( getcwd() );
            $dir  = public_path();
            $archivo        = (isset($request->nombre))? $request->nombre.".".$tipo[1] : $name_temp;
            #debuger($tipo);
            #debuger($archivo);
            $path           = $dir."/".$this->directorio;
            $ruta_file[]    = $path.$archivo;
            $ruta_update    = $this->directorio.$archivo;
            File::makeDirectory($path, 0777, true, true);
            $files[$i]->move($path,$archivo);
        }
        return json_to_object(message(true,$ruta_update,"Los archivos se subieron correctamente"));
      } catch (Exception $e) {
          $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
          return json_to_object(message(false,$error,"Ocurrio Un Error al Subir el Archivo"));
      }


    }
  /**
   * Metodo para subir los archivos al servidor.
   * @param Request $request [Description]
   * @return array [Description]
   */
    public function upload_read( Request $request ){
        
        try {
          $validacion = [];
            foreach([$this->table_model] as $key => $value){
                foreach($value->fillable as $keys => $values){
                    $validacion[] = $value->fillable[$keys];
                }
            }
            $excel = Excel::load($request->ruta)->get();
            $response = [];
            $errors_campos = [];
            foreach ($excel as $register) {
               foreach ($register as $key => $value) {
                    if( !in_array($key, $validacion) ){
                        $errors_campos[] = $key;
                    }
               }
                if( count($errors_campos) > 0){
                   unlink($request->ruta);
                   $this->datos_excel = ['success' => false ,'result' => $errors_campos,'message' => "No se puede insertar el archivo, campos distintos"];
                    return;
                }
                 $response[] = $register;   
            }
                $this->datos_excel = ['success' => true ,'result' => $response,'message' => "Se cargo correctamente los datos"];
            #debuger($this->datos_excel);
            unlink($request->ruta);
            #return ['success' => true ,'result' => $response, 'message' => "Se realizo con exito el registro"];
        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return ['success' => false ,'result' => $error,'message' => "No se puede insertar el archivo, campos distintos"];
        } 

    }
    /**
     * Metodo para insertar los datos en su respectivo modelo.
     * @param Request $request [Description]
     * @return array [Description]
     */
    public function store_register(){
        
        $error = null;
          DB::beginTransaction();
          try {
            $data = [];
            foreach( $this->datos_excel['result'] as $key => $value ){
                foreach( $value as $keys => $values ){
                    $data[$keys] = $values;
                }
                $response[] = $this->table_model::create($data);
            }
            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            return ['success' => true ,'result' => $response, 'message' => "Se realizo con exito el registro"];
          }
          return ['success' => false ,'result' => $error,'message' => "No se puede insertar el archivo"];
        
        
    }

}