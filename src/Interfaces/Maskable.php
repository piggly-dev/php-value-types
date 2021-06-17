<?php
namespace Piggly\ValueTypes\Interfaces;

interface Maskable
{
	/**
	 * Get the masked value.
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string;
}