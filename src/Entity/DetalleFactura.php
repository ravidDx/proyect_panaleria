<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetalleFacturaRepository")
 */
class DetalleFactura
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35)
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Factura", inversedBy="detalleFacturas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="detalleFacturas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productos;

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactura(): ?string
    {
        return $this->factura;
    }

    public function setFactura(string $factura): self
    {
        $this->factura = $factura;

        return $this;
    }

    public function getProducto(): ?string
    {
        return $this->producto;
    }

    public function setProducto(string $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getProductos(): ?Producto
    {
        return $this->productos;
    }

    public function setProductos(?Producto $productos): self
    {
        $this->productos = $productos;

        return $this;
    }

  
}
