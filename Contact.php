<?php

class Contact {
    private int $id;
    private string $name;
    private string $email;
    private string $phoneNumber;

    public function __construct(array $data) {
        $this->id = $data['contact_id'];
        $this->name = $data['contact_name'];
        $this->email = $data['contact_email'];
        $this->phoneNumber = $data['contact_phone_number'];
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function toString(): string {
        return "Id :" . $this->id
            . " | Name: " . $this->name
            . " | Email: " . $this->email
            . " | Phone: " . $this->phoneNumber;
    }

    public function __toString(): string {
        return $this->toString();
    }
}