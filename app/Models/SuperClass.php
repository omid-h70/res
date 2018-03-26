<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 *
 * @author Omid
 *        
 */
class SuperClass extends Model
{
    // TODO - Insert your code here
    //protected $;
    public static $NORMAL_STATUS   = 'normal';
    public static $BANNED_STATUS   = 'banned';
    public static $DELETED_STATUS  = 'deleted';
    public static $DEACTIVE_STATUS = 'deactive';
    
    
    /**
     */
    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        return $this;
        // TODO - Insert your code here
    }
    
    public function getLastInsertedId( $field = NULL ){

        if( is_null($field) ){
            $field = $this->primaryKey;
        }
        
        $row = DB::table( $this->table )
            ->select($field)
            ->orderBy($field, 'desc')
            ->take(1)
            ->get();

        foreach ( $row as $key => $value ){
            $temp_array[] = (array) $value;
        }

        if( !empty($temp_array) ){    
            return $temp_array[0][$this->primaryKey];
        }

        return FALSE;            
    }
    
    
    
}

?>