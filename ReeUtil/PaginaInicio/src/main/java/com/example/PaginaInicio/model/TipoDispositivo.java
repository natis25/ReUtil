package com.example.PaginaInicio.model;

import jakarta.persistence.*;

@Entity
@Table(name = "Tipo_dispositivo")
public class TipoDispositivo {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id_tipo;

    private String nombre_tipo;

    private Boolean aceptado;

    // Getters y Setters

    public Long getId() { return id_tipo; }
    public void setId(Long id_tipo) { this.id_tipo = id_tipo; }

    public String getNombre_tipo() { return nombre_tipo; }
    public void setNombre_tipo(String nombre_tipo) { this.nombre_tipo = nombre_tipo; }

    public Boolean getAceptado() { return aceptado; }
    public void setAceptado(Boolean aceptado) { this.aceptado = aceptado; }
}
