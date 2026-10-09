<?php
class MemberManager {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE newmember_tbl SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }

    public function getMembers($offset, $limit) {
        $stmt = $this->db->prepare("SELECT * FROM newmember_tbl WHERE status != 7 ORDER BY id ASC LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function countMembers() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM newmember_tbl WHERE status != 7");
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getMember($id) {
        $stmt = $this->db->prepare("SELECT * FROM newmember_tbl WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateMember($id, $username, $email, $phone, $address, $image) {
        $stmt = $this->db->prepare("UPDATE newmember_tbl SET username=?, email=?, phone=?, address=?, image=? WHERE id=?");
        $stmt->bind_param("sssssi", $username, $email, $phone, $address, $image, $id);
        return $stmt->execute();
    }
}
?>
