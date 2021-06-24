<?php
//La ruta de donde se ubica el modelo
namespace App\Models;
//Definir el modelo de CodeIgniter
use CodeIgniter\Model;

//Clase mismo nombre del archivo
class PedidoTicketModel extends Model
{

    public function get_venta($folio)
    {
        $db = \Config\Database::connect();
        // SELECT nombre, SUM(cantPlatillos) as cantidad, precio, SUM(subtotal) as subtotal FROM platillo INNER JOIN contiene ON contiene.idPlatillo = platillo.idPlatillo INNER JOIN pedido ON pedido.idPedido = contiene.idPedido AND pedido.idMesa = 1 GROUP BY platillo.nombre;
        return $db->query(
            'SELECT platillo.nombre, platillo.precio, contiene.subtotal, contiene.cantPlatillos
        FROM `ticket` 
        INNER JOIN `ticket_pedido` ON ticket.folioTicket = ticket_pedido.folio
        INNER JOIN `pedido` ON pedido.idPedido = ticket_pedido.idPedido
        INNER JOIN `contiene` ON contiene.idPedido = pedido.idPedido
        INNER JOIN `platillo` ON platillo.idPlatillo = contiene.idPlatillo WHERE ticket.folioTicket = ' . $folio
        )->getResultArray();
    }

    public function insert_data($folio, $idPedido)
    {
        $db = \Config\Database::connect();
        $db->query('INSERT INTO ticket_pedido VALUES ( ' . $folio . ',' . $idPedido . ' )');
    }

    public function delete_data($folio){
        $this->db->query(
            'DELETE FROM `ticket_pedido` WHERE folio = ' . $folio);
    }

    public function delete_pedido($pedido){
        $this->db->query(
            'DELETE FROM `ticket_pedido` WHERE idPedido = ' . $pedido);
    }

    public function delete_all(){
        $this->db->query('DELETE FROM `ticket_pedido`');
    }

    public function select_pedidos($folio){
        return $this->db->query(
                'SELECT * FROM `ticket_pedido` WHERE folio = ' . $folio)->getResultArray();
    }
}
