<?php

namespace App\Models;
use CodeIgniter\Model;

/*
*  Configuring Your Model
*  The model class has a few configuration options that can be set to allow the class’ methods to work seamlessly for you. 
*  The first two are used by all of the CRUD methods to determine what table to use and how we can find the required records:
*/
class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


public function xxx(){    


/* 
* find()
* Returns a single row where the primary key matches the value passed in as the first parameter:
*/
$user = $userModel->find($user_id);
$users = $userModel->find([1,2,3]);


/*
* findColumn()
* Returns null or an indexed array of column values:
*/
$user = $userModel->findColumn($column_name);

/*
* findAll()
Returns all results:
*/
$users = $userModel->findAll();
$users = $userModel->where('active', 1)
                   ->findAll();
$users = $userModel->findAll($limit, $offset);


/*
* first()
* Returns the first row in the result set. This is best used in combination with the query builder.
*/
$user = $userModel->where('deleted', 0)
                  ->first();


/*
* insert()
* An associative array of data is passed into this method as the only parameter to create a new row of data in the database. 
* The array’s keys must match the name of the columns in a $table, while the array’s values are the values to save for that key:
*/                  
$data = [
    'username' => 'darth',
    'email'    => 'd.vader@theempire.com'
];
$userModel->insert($data);


/* update()
* Updates an existing record in the database. The first parameter is the $primaryKey of the record to update. 
* An associative array of data is passed into this method as the second parameter. The array’s keys must match the name 
* of the columns in a $table, while the array’s values are the values to save for that key.
*/
$data = [
    'username' => 'darth',
    'email'    => 'd.vader@theempire.com'
];
$userModel->update($id, $data);


/* Multiple records may be updated with a single call by passing an array of primary keys as the first parameter. */
$data = ['active' => 1];
$userModel->update([1, 2, 3], $data);


/* When you need a more flexible solution, you can leave the parameters empty and it functions like the Query Builder’s update command, 
*  with the added benefit of validation, events, etc:
*/
$userModel->whereIn('id', [1,2,3])
          ->set(['active' => 1])
          ->update();


/* save()
* This is a wrapper around the insert() and update() methods that handle inserting or updating the record automatically, 
* based on whether it finds an array key matching the $primaryKey value:
*/

// Defined as a model property
$primaryKey = 'id';

// Does an insert()
$data = [
    'username' => 'darth',
    'email'    => 'd.vader@theempire.com'
];
$userModel->save($data);


// Performs an update, since the primary key, 'id', is found.
$data = [
    'id'       => 3,
    'username' => 'darth',
    'email'    => 'd.vader@theempire.com'
];
$userModel->save($data);    



/* delete()
* Takes a primary key value as the first parameter and deletes the matching record from the model’s table:
*/
$userModel->delete(12);
$userModel->delete([1,2,3]);


/* ------------------------------------------------------------------------------------------------------------------
*                                            - Query Builder -
--------------------------------------------------------------------------------------------------------------------*/  

/* Builder (alterando a tabela) */
$this->builder = $this->builder('produto p');


/* Direct Query */
$vSQL = 'select * from produto where descricao = ' .addslashes($descricao);
$query = $this->db->query($vSQL, false);
return $query->getResult();    
return $query->getResultArray();            


/* 
* $builder->get()
* Runs the selection query and returns the result. Can be used by itself to retrieve all records from a table:
*/
$builder = $db->table('mytable');
$query   = $builder->get();  // Produces: SELECT * FROM mytable


/* limit */
$query = $builder->get(10, 20);  // Executes: SELECT * FROM mytable LIMIT 20, 10


/*
* You’ll notice that the above function is assigned to a variable named $query, which can be used to show the results:
*/
$query = $builder->get();
foreach ($query->getResult() as $row){
    echo $row->title;
}


/* 
* $builder->getCompiledSelect()
* Compiles the selection query just like $builder->get() but does not run the query. This method simply returns the SQL query as a string.
* Example:
*/
$sql = $builder->getCompiledSelect();
echo $sql; // Prints string: SELECT * FROM mytable
echo $builder->limit(10,20)->getCompiledSelect(false); // Prints string: SELECT * FROM mytable LIMIT 20, 10
echo $builder->select('title, content, date')->getCompiledSelect(); // Prints string: SELECT title, content, date FROM mytable LIMIT 20, 10



/* 
* $builder->getWhere()
* Identical to the get() function except that it permits you to add a “where” clause in the first parameter, instead of using the db->where() function:
*/
$query = $builder->getWhere(['id' => $id], $limit, $offset);




/*
* $builder->select() accepts an optional second parameter. 
* If you set it to false, CodeIgniter will not try to protect your field or table names. This is useful if you need a compound 
* select statement where automatic escaping of fields may break them.
*/
$builder->select('(SELECT SUM(payments.amount) FROM payments WHERE payments.invoice_id=4) AS amount_paid', false);
$query = $builder->get();



/*
* $builder->selectMax(), $builder->selectMin(), $builder->selectAvg()
*/
$builder->selectMax('age');
$query = $builder->get(); // Produces: SELECT MAX(age) as age FROM mytable

$builder->selectMax('age', 'member_age');
$query = $builder->get(); // Produces: SELECT MAX(age) as member_age FROM mytable

$builder->selectMin('age');
$query = $builder->get(); // Produces: SELECT MIN(age) as age FROM mytable


$builder->selectAvg('age');
$query = $builder->get(); // Produces: SELECT AVG(age) as age FROM mytable


/*
* $builder->selectSum(), $builder->selectCount()
*/
$builder->selectSum('age');
$query = $builder->get(); // Produces: SELECT SUM(age) as age FROM mytable

$builder->selectCount('age');
$query = $builder->get(); // Produces: SELECT COUNT(age) as age FROM mytable


/*
* $builder->from()
* Permits you to write the FROM portion of your query:
*/
$builder = $db->table('users');
$builder->select('title, content, date');
$builder->from('mytable');
$query = $builder->get(); // Produces: SELECT title, content, date FROM users, mytable

/*
* $builder->join()
* Permits you to write the JOIN portion of your query:
*/
$builder = $db->table('blogs');
$builder->select('*');
$builder->join('comments', 'comments.id = blogs.id');
$query = $builder->get(); // Produces: SELECT * FROM blogs JOIN comments ON comments.id = blogs.id


/*
* $builder->where()
* This function enables you to set WHERE clauses using one of four methods:
* Note: All values passed to this function are escaped automatically, producing safer queries.
*/
$builder->where('name', $name); // Produces: WHERE name = 'Joe'

/*
* If you use multiple function calls they will be chained together with AND between them:
*/
$builder->where('name', $name);
$builder->where('title', $title);
$builder->where('status', $status); // WHERE name = 'Joe' AND title = 'boss' AND status = 'active'


/*
* You can include an operator in the first parameter in order to control the comparison:
*/
$builder->where('name !=', $name);
$builder->where('id <', $id); // Produces: WHERE name != 'Joe' AND id < 45


/*
* Associative array method:
*/
$array = ['name' => $name, 'title' => $title, 'status' => $status];
$builder->where($array); // Produces: WHERE name = 'Joe' AND title = 'boss' AND status = 'active'

/* 
* You can include your own operators using this method as well:
*/
$array = ['name !=' => $name, 'id <' => $id, 'date >' => $date];
$builder->where($array);


/*
* Custom string:
* You can write your own clauses manually:
*/
$where = "name='Joe' AND status='boss' OR status='active'";
$builder->where($where);


/*
* $builder->where() accepts an optional third parameter. If you set it to false, CodeIgniter will not try to protect your field or table names.
*/
$builder->where('MATCH (field) AGAINST ("value")', null, false);


/*
* Subqueries:
* You can use an anonymous function to create a subquery.
*/
$builder->where('advance_amount <', function(BaseBuilder $builder) {
    return $builder->select('MAX(advance_amount)', false)->from('orders')->where('id >', 2);
});
// Produces: WHERE "advance_amount" < (SELECT MAX(advance_amount) FROM "orders" WHERE "id" > 2)



/*
* $builder->orWhere(), $builder->whereIn(), $builder->whereNotIn(), $builder->orWhereNotIn() 
*/
$builder->where('name !=', $name);
$builder->orWhere('id >', $id); // Produces: WHERE name != 'Joe' OR id > 50

$names = ['Frank', 'Todd', 'James'];
$builder->whereIn('username', $names); // Produces: WHERE username IN ('Frank', 'Todd', 'James')

$builder->whereIn('id', function(BaseBuilder $builder) {
    return $builder->select('job_id')->from('users_jobs')->where('user_id', 3);
}); // Produces: WHERE "id" IN (SELECT "job_id" FROM "users_jobs" WHERE "user_id" = 3)

$names = ['Frank', 'Todd', 'James'];
$builder->orWhereIn('username', $names); // Produces: OR username IN ('Frank', 'Todd', 'James')



/*
* $builder->like()
*/
$builder->like('title', 'match'); // Produces: WHERE `title` LIKE '%match%' ESCAPE '!'


$builder->like('title', 'match');
$builder->like('body', 'match');  // WHERE `title` LIKE '%match%' ESCAPE '!' AND  `body` LIKE '%match%' ESCAPE '!'


$builder->like('title', 'match', 'before'); // Produces: WHERE `title` LIKE '%match' ESCAPE '!'
$builder->like('title', 'match', 'after');  // Produces: WHERE `title` LIKE 'match%' ESCAPE '!'
$builder->like('title', 'match', 'both');   // Produces: WHERE `title` LIKE '%match%' ESCAPE '!'


$array = ['title' => $match, 'page1' => $match, 'page2' => $match];
$builder->like($array);  // WHERE `title` LIKE '%match%' ESCAPE '!' AND  `page1` LIKE '%match%' ESCAPE '!' AND  `page2` LIKE '%match%' ESCAPE '!'


$builder->like('title', 'match'); $builder->orLike('body', $match);
// WHERE `title` LIKE '%match%' ESCAPE '!' OR  `body` LIKE '%match%' ESCAPE '!'


$builder->notLike('title', 'match'); // WHERE `title` NOT LIKE '%match% ESCAPE '!'



/* 
* $builder->groupBy()
*/
$builder->groupBy("title"); // Produces: GROUP BY title
$builder->groupBy(["title", "date"]); // Produces: GROUP BY title, date


/*
* $builder->distinct()
*/
$builder->distinct();
$builder->get(); // Produces: SELECT DISTINCT * FROM mytable

/*
* $builder->having()
*/
$builder->having('user_id = 45'); // Produces: HAVING user_id = 45
$builder->having('user_id',  45); // Produces: HAVING user_id = 45
$builder->having(['title =' => 'My Title', 'id <' => $id]); // Produces: HAVING title = 'My Title', id < 45


/*
* $builder->orderBy()
*/
$builder->orderBy('title', 'DESC'); // Produces: ORDER BY `title` DESC
$builder->orderBy('title DESC, name ASC'); // Produces: ORDER BY `title` DESC, `name` ASC
$builder->orderBy('title', 'DESC');
$builder->orderBy('name', 'ASC'); // Produces: ORDER BY `title` DESC, `name` ASC


/*
* Inserting Data
* $builder->insert()
* Generates an insert string based on the data you supply, and runs the query. You can either pass an array or an object to the function. Here is an example using an array:
*/
$data = [
    'title' => 'My title',
    'name'  => 'My Name',
    'date'  => 'My date',
];
$builder->insert($data);


class Myclass{
    public $title   = 'My Title';
    public $content = 'My Content';
    public $date    = 'My Date';
}
$object = new Myclass;
$builder->insert($object); // Produces: INSERT INTO mytable (title, content, date) VALUES ('My Title', 'My Content', 'My Date')


/*
* $builder->getCompiledInsert()
* Compiles the insertion query just like $builder->insert() but does not run the query. This method simply returns the SQL query as a string.
*/
$data = [
    'title' => 'My title',
    'name'  => 'My Name',
    'date'  => 'My date',
];
$sql = $builder->set($data)->getCompiledInsert('mytable');
echo $sql;


/*
* $builder->insertBatch()
* Generates an insert string based on the data you supply, and runs the query. You can either pass an array or an object to the function. Here is an example using an array:
*/
$data = [
    [
        'title' => 'My title',
        'name'  => 'My Name',
        'date'  => 'My date',
    ],
    [
        'title' => 'Another title',
        'name'  => 'Another Name',
        'date'  => 'Another date',
    ],
];
$builder->insertBatch($data);
// Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date'),  ('Another title', 'Another name', 'Another date')



/*
* Updating Data
* $builder->replace()
* This method executes a REPLACE statement, which is basically the SQL standard for (optional) DELETE + INSERT, using PRIMARY and UNIQUE keys 
* as the determining factor. In our case, it will save you from the need to implement complex logics with different combinations of select(), update(), delete() and insert() calls.
*/
$data = [
    'title' => 'My title',
    'name'  => 'My Name',
    'date'  => 'My date',
];
$builder->replace($data);
// Executes: REPLACE INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')


/*
* $builder->set()
* This function enables you to set values for inserts or updates.
* It can be used instead of passing a data array directly to the insert or update functions:
*/
$builder->set('name', $name);
$builder->insert();
// Produces: INSERT INTO mytable (`name`) VALUES ('{$name}')


$builder->set('name', $name);
$builder->set('title', $title);
$builder->set('status', $status);
$builder->insert();
// set() will also accept an optional third parameter ($escape), that will prevent data from being escaped if set to false. 
// To illustrate the difference, here is set() used both with and without the escape parameter.


$builder->set('field', 'field+1', false);
$builder->where('id', 2);
$builder->update();
// gives UPDATE mytable SET field = field+1 WHERE `id` = 2


$builder->set('field', 'field+1');
$builder->where('id', 2);
$builder->update();
// gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2


/*
* $builder->update()
* Generates an update string and runs the query based on the data you supply. You can pass an array or an object to the function. Here is an example using an array:
*/
$data = [
    'title' => $title,
    'name'  => $name,
    'date'  => $date,
];
$builder->where('id', $id);
$builder->update($data);
//  UPDATE mytable  SET title = '{$title}', name = '{$name}', date = '{$date}' WHERE id = $id


/*
* $builder->updateBatch()
* Generates an update string based on the data you supply, and runs the query. You can either pass an array or an object to the function. Here is an example using an array:
*/
$data = [
   [
      'title' => 'My title' ,
      'name'  => 'My Name 2' ,
      'date'  => 'My date 2',
   ],
   [
      'title' => 'Another title' ,
      'name'  => 'Another Name 2' ,
      'date'  => 'Another date 2',
   ],
];
$builder->updateBatch($data, 'title');
// Produces:
// UPDATE `mytable` SET `name` = CASE
// WHEN `title` = 'My title' THEN 'My Name 2'
// WHEN `title` = 'Another title' THEN 'Another Name 2'
// ELSE `name` END,
// `date` = CASE
// WHEN `title` = 'My title' THEN 'My date 2'
// WHEN `title` = 'Another title' THEN 'Another date 2'
// ELSE `date` END
// WHERE `title` IN ('My title','Another title')

//$compiled = $this->builder->getCompiledSelect();    