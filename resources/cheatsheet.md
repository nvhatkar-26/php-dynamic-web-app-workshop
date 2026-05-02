## PHP Basics
echo "Hello";

## POST Data
$_POST['name'];

## MySQL Insert
INSERT INTO students (name) VALUES ('John');

## Loop
while ($row = $result->fetch_assoc()) {
    echo $row['name'];
}