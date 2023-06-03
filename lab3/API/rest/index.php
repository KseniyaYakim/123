<?php

use Symfony\Component\HttpFoundation\Request;

require_once 'C:\xampp\htdocs\lab3\vendor\autoload.php';
require_once "../classes/countries.php";
require_once "../classes/childrens.php";
$app = new Silex\Application();


$app->get('/childrens/list.json', function () use ($app) {
    $childrens = new Childrens();
    $needCountries = true;
    $list = $childrens->read($needCountries);
    return $app->json(array_values($list));
});
$app->post('/childrens/list-filtered', function (Request $request) use ($app){
    $childrens = new Childrens();
    $needCountries = true;
    $data = json_decode($request->getContent(), true);
    $list = $childrens->read($needCountries,$data["id"]);
    return $app->json(array_values($list));
});
$app->post('/childrens/add-item', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $name = $data["name"] ?? null;
    $age = $data["age"] ?? null;
    $countryId = intval($data["country"]) ?? null;
    $img_path=$data["img_path"]??null;
    $countries = new Countries();
    if ($name && $age && $countryId && $countries->exists($countryId)) {
        $childrens = new Childrens();
        try {
            $childrens->create(['name' => $name, "age" => $age, "img_path"=>$img_path,"country" => $countryId]);
            $lastId = $childrens->lastID();
            return $app->json(["create-children" => "yes", "create-id" => $lastId]);
        } catch (PDOException $e) {
            return $app->json(["error" => $e->getMessage(), "create-children" => "no"]);
        }
    } else {
        return $app->json(["create-children" => "no"]);
    }
});
$app->post('/childrens/upload-image', function () use ($app){
    $childrens = new Childrens();
    try {
        $response=$childrens->uploadImage();
    }catch (Exception $ex){
        return $app->json(["Exception" => $ex]);
    }
    return $app->json($response);
});
$app->post('/childrens/update-item', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $id = intval($data["id"]);
    $childrens = new Childrens();
    $childrens->deleteImage($id);
    $name = $data["name"] ?? null;
    $age = $data["age"] ?? null;
    $img_path=$data["img_path"]??null;
    $countryId = intval($data["country"] ?? null);
    if ($childrens->exists($id) && $name && $age && $countryId) {
        try {
            $childrens->update(["id" => $id, "name" => $name, "age" => $age,"img_path"=>$img_path, "country" => $countryId]);
            return $app->json(["update-children" => "yes", "id_update" => $id]);
        } catch (PDOException $e) {
            return $app->json(["error" => $e->getMessage(), "update-children" => "no"]);
        }
    } else {
        return $app->json(["update-children" => "no"]);
    }
});

$app->post('/childrens/delete-item', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $id = intval($data["id"]);
    $childrens = new Childrens();
    if ($childrens->exists($id)) {
        try {
            $childrens->deleteImage($id);
            $childrens->delete($id);
            return $app->json(["delete-children" => "yes", "id_delete" => $id]);
        } catch (PDOException $e) {
            return $app->json(["error" => $e->getMessage(), "delete-children" => "no"]);
        }
    } else {
        return $app->json(["delete-children" => "no"]);
    }
});

$app->get('/countries/list.json', function () use ($app) {
    $countries = new Countries();
    $list = $countries->read();
    return $app->json(array_values($list));
});

$app->post('/countries/add-item', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $country = $data['country'] ?? null;
    if ($country) {
        $countries = new Countries();
        try {
            $countries->create(["country" => $country]);
            $lastId = $countries->lastID();
            return $app->json(["create-country" => "yes", "create-id" => $lastId]);
        } catch (PDOException $e) {
            return $app->json(["error" => $e->getMessage(), "create-country" => "no"]);
        }
    } else {
        return $app->json(["create-country" => "no"]);
    }
});
$app->post('/countries/update-item', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $countries = new Countries();
    $countryId = intval($data["id"]  ?? null);
    $country = $data['country']  ?? null;

    if ($countries->exists($countryId) && $country) {
        try {
            $countries->update(["id" => $countryId, "country" => $country]);
            return $app->json(["update-country" => "yes", "id_update" => $countryId]);
        } catch (PDOException $e) {
            return $app->json(["error" => $e->getMessage(), "update-country" => "no"]);
        }
    } else {
        return $app->json(["update-country" => "no"]);
    }
});
$app->post('/countries/delete-item', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $countries = new Countries();
    $id = intval($data["id"] ?? null);
    if ($countries->exists($id)) {
        try {
            $countries->delete($id);
            return $app->json(["delete-country" => "yes", "id_delete" => $id]);
        } catch (PDOException $e) {
            return $app->json(["error" => $e->getMessage(), "delete-country" => "no"]);
        }
    } else {
        return $app->json(["delete-country" => "no"]);
    }
});


$app->run();