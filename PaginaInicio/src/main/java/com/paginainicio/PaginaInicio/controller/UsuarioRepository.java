
package com.paginainicio.PaginaInicio.controller;

import com.paginainicio.PaginaInicio.model.Usuario;
import org.springframework.data.jpa.repository.JpaRepository;

public interface UsuarioRepository extends JpaRepository<Usuario, Long> {
    Usuario findByCuentaAndContrasena(String cuenta, String contrasena);
}
