<?php

namespace Wooturk;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;

class OptionController extends Controller
{
	function index(Request $request){
		$data = [
			['GET', 'options', 'Ürün Seçenek listesi'],
			['GET', 'option', 'Servis Açıklaması'],
			['POST', 'option', 'Ürün Seçenek Oluşturma'],
			['GET', 'option/{id}', 'Tek Bir Ürün Seçenek Bilgisi'],
			['PUT', 'option/{id}', 'Tek Bir Ürün Seçenek Günceleme'],
			['DELETE', 'option/{id}', 'Tek Bir Ürün Seçenek Silme'],
		];
		return Response::success("Lütfen Giriş Yapınız", $data);
	}
	function list(Request $request){
		if($rows = get_options( $request->all() )){
			return Response::success("Ürün Seçenek Bilgileri", $rows);
		}
		return Response::failure("Ürün Seçenek Bulunamadı");
	}
	function get(Request $request, $id){
		if($row = get_option($id)){
			return Response::success("Ürün Seçenek Bilgileri", $row);
		}
		return Response::failure("Ürün Seçenek Bulunamadı");
	}
	function post(Request $request) {
		if (!$request->hasHeader('X-Wooturk-Key')) {
			return Response::failure("Bu işlem için yetkili değilsiniz");
		}
		if($request->header('X-Wooturk-Key')!=env('WOOTURK_KEY')){
			return Response::failure("Anahtarnız bu işlem için geçerli değil");
		}
		$exception = '';
		try {
			$fields = $request->validate([
				'name' => 'required|string|max:255',
				'email' => 'required|email|unique:options',
				'password' => 'required|string|max:16',
			]);
			$row = create_option($fields);
			if($row){
				return Response::success("Ürün Seçenek Oluşturuldu", $row);
			}
			return Response::failure("Ürün Seçenek Oluşturulamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
	function put(Request $request, $id){
		$exception = '';
		try {
			$fields = $request->validate([
				'name' => 'required|string|max:255',
				'password' => 'required|string|max:16',
			]);

			$row = update_option($id, $fields);
			if($row){
				return Response::success("Ürün Seçenek Güncellendi", $row);
			}
			return Response::failure("Ürün Seçenek Güncellenemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( '$exception');
	}
	function delete(Request $request, $id){
		$exception = '';
		try {
			if( $row = delete_option($id)){
				return Response::success("Ürün Seçenek Silindi", $row);
			}
			return Response::failure("Ürün Seçenek Bulunamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
}
