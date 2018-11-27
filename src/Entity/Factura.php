<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FacturaRepository")
 */
class Factura
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroFactura;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaAt;

    /**
     * @ORM\Column(type="float")
     */
    private $totalVenta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estadoFactura;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetalleFactura", mappedBy="factura", orphanRemoval=true)
     */
    private $detalleFacturas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="facturas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="facturas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendedor;

    public function __construct()
    {
        $this->detalleFacturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFactura(): ?int
    {
        return $this->numeroFactura;
    }

    public function setNumeroFactura(int $numeroFactura): self
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    public function getFechaAt(): ?\DateTimeInterface
    {
        return $this->fechaAt;
    }

    public function setFechaAt(\DateTimeInterface $fechaAt): self
    {
        $this->fechaAt = $fechaAt;

        return $this;
    }

    public function getCliente(): ?string
    {
        return $this->cliente;
    }

    public function setCliente(string $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getVendedor(): ?string
    {
        return $this->vendedor;
    }

    public function setVendedor(string $vendedor): self
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    public function getTotalVenta(): ?float
    {
        return $this->totalVenta;
    }

    public function setTotalVenta(float $totalVenta): self
    {
        $this->totalVenta = $totalVenta;

        return $this;
    }

    public function getEstadoFactura(): ?bool
    {
        return $this->estadoFactura;
    }

    public function setEstadoFactura(bool $estadoFactura): self
    {
        $this->estadoFactura = $estadoFactura;

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
            $detalleFactura->setFactura($this);
        }

        return $this;
    }

    public function removeDetalleFactura(DetalleFactura $detalleFactura): self
    {
        if ($this->detalleFacturas->contains($detalleFactura)) {
            $this->detalleFacturas->removeElement($detalleFactura);
            // set the owning side to null (unless already changed)
            if ($detalleFactura->getFactura() === $this) {
                $detalleFactura->setFactura(null);
            }
        }

        return $this;
    }
}
