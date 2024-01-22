<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Schema;

class GenerateDTO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dto {table} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $tableName = $this->argument('table');
        $dtoName = $this->argument('name');
        $folder = "";
        if (str_contains($dtoName, "/")) {
            $newStr = explode("/", $dtoName);
            $folder = $newStr[0];
            $dtoName = $newStr[1];
        } 
    
        $interface = str_replace(["Dto", "DTO", "dto"], "", $dtoName);
        $dtoName =  $interface."Dto";
        //$tableColumns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $requestvalidate = '$request->validated';
        $request = "request";
        $dtoProperties = '';
        $dtoProperties .= "public function __construct(\n ";
        
        foreach (Schema::getColumnListing($tableName) as $column) {
            $columnType = Schema::getColumnType($tableName, $column);
            if ($columnType == "integer") {
                $columnType =  "Int";
            } else {
                $columnType =  "string";
            }

            $dtoProperties .= "      ". "public readonly ?$columnType \${$column},\n";
        }


        $dtoProperties .= "    "."){}";

        $dtoProperties .= "public function toArray()
        {\n  return [ \n";
            foreach (Schema::getColumnListing($tableName) as $column) {
                $dtoProperties .= "            "."'".$column."' =>$"."this->".$column.",\n";
            }
        $dtoProperties .= "];  \n } \n  ";  
        $dtoProperties .= "
        public static function fromApiRequest(Store{$interface}Request|Update{$interface}Request  \${$request}): $dtoName
        {
            return new self(\n";
        foreach (Schema::getColumnListing($tableName) as $column) {
            $dtoProperties .= "            " .$column . ": $requestvalidate('$column'),\n";
        }
        $dtoProperties .= "    ".");\n";

        $dtoProperties .= "}\n";
        if($folder){
          $nameSpace =   "\\".$folder; 
          $dtoContent = "<?php\n\nnamespace App\Dtos$nameSpace;\nclass {$dtoName}\n{\n    {$dtoProperties}\n}";
         }else{
          $dtoContent = "<?php\n\nnamespace App\Dtos;\nclass {$dtoName}\n{\n    {$dtoProperties}\n}";
         }
         
        if($folder){
            $process = new Process(['mkdir', app_path("Dtos/$folder")]);
            $process->run();
            if ($process->isSuccessful()) {
                $this->info('Modulo ha sido creado exitosamente.');
            } else {
                //$this->error('Ha ocurrido un error al crear la carpeta.');
            }
            file_put_contents(app_path("Dtos/{$folder}/{$dtoName}.php"), $dtoContent);
        }else{
            file_put_contents(app_path("Dtos/{$dtoName}.php"), $dtoContent);
        }

        $this->info("DTO {$dtoName} generado correctamente!");
    }
}
