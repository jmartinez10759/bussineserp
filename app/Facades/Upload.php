<?php
namespace App\Facades;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Maatwebsite\Excel\Facades\Excel;

class Upload extends Facade
{
    public  $excelData = [];

    public  $_entity;
    /**
     * @var string
     */
    private $_directory;
    /**
     * @var string
     */
    private $_mainDirectory;

    /**
     * Upload constructor.
     * @param $directory
     */
    public function __construct($directory )
    {
        $this->_directory       = (!$directory)? "upload_file/catalogs/" : $directory;
        $this->_mainDirectory   = public_path();
    }

    /**
     * This is method is used to file upload to the server
     * @param Request $request [Description]
     * @return array [Description]
     */
    public function uploadFile( Request $request )
    {
      ini_set('memory_limit', '-1');
      set_time_limit(0);
      $files = $request->file;
      try {
          $pathFile = [];
          $updatePath = [];
        for ($i=0; $i < count( $files ) ; $i++) {
            $contentFiles      	= file_get_contents($files[$i]);
            $name_temp    	    = $files[$i]->getClientOriginalName();
            $ext      		    = strtolower($files[$i]->getClientOriginalExtension());
            $type 			    = $files[$i]->getMimeType();
            $types              = explode('/', $type);
            $contentFiles       = (isset($request->name))? $request->get("name").".".$types[1] : $name_temp;

            $path               = $this->_mainDirectory."/".$this->_directory;
            $pathFile[]         = $path.$contentFiles;
            $updatePath[]       = $this->_directory.$contentFiles;
            File::makeDirectory($path, 0777, true, true);
            $files[$i]->move($path,$contentFiles);
        }
          \Log::debug($updatePath);
        return [
            'path' => $updatePath ,
            'success' => true
        ];
      } catch ( \Exception $e) {
          $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
          \Log::debug($error);
          return ['success' => false ];
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
            foreach([$this->_entity] as $key => $value){
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
                   $this->excelData = ['success' => false ,'result' => $errors_campos,'message' => "No se puede insertar el archivo, campos distintos"];
                    return;
                }
                 $response[] = $register;   
            }
                $this->excelData = ['success' => true ,'result' => $response,'message' => "Se cargo correctamente los datos"];
            #debuger($this->$this->excelData);
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
            foreach( $this->excelData['result'] as $key => $value ){
                foreach( $value as $keys => $values ){
                    $data[$keys] = $values;
                }
                $response[] = $this->_entity::create($data);
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