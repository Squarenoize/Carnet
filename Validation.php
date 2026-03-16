<?php
abstract class Validation {
    /**
     * Valide une adresse e-mail en utilisant un filtre de validation.
     * @param string $email L'adresse e-mail à valider.
     * @return bool True si l'adresse e-mail est valide, sinon false.
     */
    public static function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Valide un numéro de téléphone en vérifiant qu'il contient uniquement des chiffres et a une longueur définie.
     * @param string $phoneNumber Le numéro de téléphone à valider.
     * @return bool True si le numéro de téléphone est valide, sinon false.
     */
    public static function validatePhoneNumber(string $phoneNumber): bool {
        // Suppression des espaces et des tirets pour la validation
        $cleaned = str_replace([' ', '-'], '', $phoneNumber);
        return preg_match('/^\d{10}$/', $cleaned) === 1;
    }
}