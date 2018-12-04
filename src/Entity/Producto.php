<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
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
    private $barcode;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIva;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fchIngreso;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantPack;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantUnit;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantTotal;

    /**
     * @ORM\Column(type="float")
     */
    private $precioPack;

    /**
     * @ORM\Column(type="float")
     */
    private $precioUnit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetalleFactura", mappedBy="productos")
     */
    private $detalleFacturas;

    public function __construct()
    {
        $this->detalleFacturas = new ArrayCollection();
    }


 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getIsIva(): ?bool
    {
        return $this->isIva;
    }

    public function setIsIva(bool $isIva): self
    {
        $this->isIva = $isIva;

        return $this;
    }

    public function getFchIngreso(): ?\DateTimeInterface
    {
        return $this->fchIngreso;
    }

    public function setFchIngreso(\DateTimeInterface $fchIngreso): self
    {
        $this->fchIngreso = $fchIngreso;

        return $this;
    }

    public function getCantPack(): ?int
    {
        return $this->cantPack;
    }

    public function setCantPack(int $cantPack): self
    {
        $this->cantPack = $cantPack;

        return $this;
    }

    public function getCantUnit(): ?int
    {
        return $this->cantUnit;
    }

    public function setCantUnit(int $cantUnit): self
    {
        $this->cantUnit = $cantUnit;

        return $this;
    }

    public function getCantTotal(): ?int
    {
        return $this->cantTotal;
    }

    public function setCantTotal(int $cantTotal): self
    {
        $this->cantTotal = $cantTotal;

        return $this;
    }

    public function getPrecioPack(): ?float
    {
        return $this->precioPack;
    }

    public function setPrecioPack(float $precioPack): self
    {
        $this->precioPack = $precioPack;

        return $this;
    }

    public function getPrecioUnit(): ?float
    {
        return $this->precioUnit;
    }

    public function setPrecioUnit(float $precioUnit): self
    {
        $this->precioUnit = $precioUnit;

        return $this;
    }

    /**
     * @return Collection|DetalleFactura[]
     */
    public function getDetalleFacturas(): Collection
    {
        return $this->detalleFacturas;
    }

    public function addDetalleFactura(DetalleFactura $detalleFactura): self
    {
        if (!$this->detalleFacturas->contains($detalleFactura)) {
            $this->detalleFacturas[] = $detalleFactura;
            $detalleFactura->setProductos($this);
        }

        return $this;
    }

    public function removeDetalleFactura(DetalleFactura $detalleFactura): self
    {
        if ($this->detalleFacturas->contains($detalleFactura)) {
            $this->detalleFacturas->removeElement($detalleFactura);
            // set the owning side to null (unless already changed)
            if ($detalleFactura->getProductos() === $this) {
                $detalleFactura->setProductos(null);
            }
        }

        return $this;
    }

   

}
