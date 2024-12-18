<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/utils/JWTHandler.php');

class ProductApiController
{
    private $JWTHandler;
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->JWTHandler = new JWTHandler();
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Xác thực token
    private function authenticateRequest()
    {
        try {
            // Xác thực token, trả về dữ liệu người dùng nếu thành công
            return $this->JWTHandler->authenticateToken();
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized: ' . $e->getMessage()]);
            exit;
        }
    }

    // Lấy danh sách sản phẩm
    public function index()
    {
        $decodedToken = $this->authenticateRequest(); // Xác thực token
        header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }

    // Lấy thông tin sản phẩm theo ID
    public function show($id)
    {
        $decodedToken = $this->authenticateRequest(); // Xác thực token
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    // Thêm sản phẩm mới
    public function store()
    {
        $decodedToken = $this->authenticateRequest(); // Xác thực token
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;
        $result = $this->productModel->addProduct(
            $name,
            $description,
            $price,
            $category_id,
            null
        );
        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }

    // Cập nhật sản phẩm theo ID
    // Cập nhật sản phẩm theo ID
public function update($id)
{
    $decodedToken = $this->authenticateRequest(); // Xác thực to
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra xem dữ liệu có hợp lệ không
    if (!$data) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input data']);
        return;
    }

    $name = $data['name'] ?? '';
    $description = $data['description'] ?? '';
    $price = $data['price'] ?? '';
    $category_id = $data['category_id'] ?? null;
    $id = (double) $id;
    // Gọi phương thức updateProduct với ID hợp lệ
    $result = $this->productModel->updateProduct(
        $id,  // ID giờ đã là kiểu DOUBLE
        $name,
        $description,
        $price,
        $category_id,
        null
    );

    if ($result) {
        echo json_encode(['message' => 'Product updated successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Product update failed']);
    }
}


    // Xóa sản phẩm theo ID
    public function destroy($id) 
    { 
        header('Content-Type: application/json'); 
        $id = (double) $id;
        $result = $this->productModel->deleteProduct($id); 
        if ($result) { 
        echo json_encode(['message' => 'Product deleted successfully']); 
        } else { 
http_response_code(400); 
echo json_encode(['message' => 'Product deletion failed']); 
} 
}
}
