<?php

namespace App\Models\User;

class UserWriteRepository
{
    public function __construct(
        protected readonly \PDO $conn
    ) {
    }

    public static function getTableColumns(): string
    {
        return "
            usr.id,
            usr.name,
            usr.email,
            usr.password,
            usr.user_type as userType
        ";
    }

    public function save(UserModel $model): void
    {
        $sql = "
            INSERT INTO users (
                name,
                email,
                password,
                user_type
            ) VALUES (
                :name,
                :email,
                :password,
                :user_type
            )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue('name', $model->name ?? "John Doe");
        $stmt->bindValue('email', $model->email ?? "john@doe.com");
        $stmt->bindValue('password', $model->password ?? "123456");
        $stmt->bindValue('user_type', $model->userType ?? "user");

        $stmt->execute();
    }
}
