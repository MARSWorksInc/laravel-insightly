<?php

namespace Marsworksinc\LaravelInsightly;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class LaravelInsightly
{
    public function __construct(
        protected string $url,
        protected string $key,
        protected string $version,
    ) {
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function getInstance(): ?array
    {
        $response = Http::withBasicAuth($this->getKey(), '')->get(
            $this->getMethodUrl("Instance")
        );

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getContact(int $id): ?Contact
    {
        $response = Http::withBasicAuth($this->getKey(), '')->get($this->getMethodUrl("Contacts/$id"));

        if ($response->successful()) {
            $responseData = $response->json();

            return new Contact(
                id: $responseData['CONTACT_ID'],
                firstName: $responseData['FIRST_NAME'],
                lastName: $responseData['LAST_NAME'],
                email: $responseData['EMAIL_ADDRESS'],
                salutation: $responseData['SALUTATION'],
                organization: $responseData['ORGANISATION_ID'],
                tags: $responseData['TAGS'],
            );
        }

        return null;
    }

    public function getOrganization(int $id): ?Organization
    {
        $response = Http::withBasicAuth($this->getKey(), '')->get($this->getMethodUrl("Organisations/$id"));

        if ($response->successful()) {
            $responseData = $response->json();

            return new Organization(
                id: $responseData['ORGANISATION_ID'],
                name: $responseData['ORGANISATION_NAME'],
            );
        }

        return null;
    }

    /**
     * Search Organizations in Insightly by the ORGANISATION_NAME field
     *
     * @param string $search Search text
     * @param int $top How many records should this return
     * @return Collection
     */
    public function searchOrganizations(string $search, int $top = 50): Collection
    {
        $organizations = collect();

        $response = Http::withBasicAuth($this->getKey(), '')
            ->get($this->getMethodUrl("Organisations/Search?field_name=ORGANISATION_NAME&field_value=$search&top=$top"));

        if ($response->successful()) {
            $responseData = $response->json();

            foreach ($responseData as $responseDatum) {
                $organizations->push(
                    new Organization(
                        id: $responseDatum['ORGANISATION_ID'],
                        name: $responseDatum['ORGANISATION_NAME'],
                    )
                );
            }
        }

        return $organizations;
    }

    /**
     * Search Contacts in Insightly
     *
     * @param string $field What Insightly Field to search by
     * @param string $search Search text
     * @param int $top How many records should this return
     * @return Collection
     */
    public function searchContacts(string $field, string $search, int $top = 50): Collection
    {
        $contacts = collect();

        $query = "field_name=$field&field_value=$search&top=$top";

        $response = Http::withBasicAuth($this->getKey(), '')
            ->get($this->getMethodUrl(
                "Contacts/Search?$query"
            ));

        if ($response->successful()) {
            $responseData = $response->json();

            foreach ($responseData as $responseDatum) {
                $contacts->push(
                    new Contact(
                        id: $responseDatum['CONTACT_ID'],
                        firstName: $responseDatum['FIRST_NAME'],
                        lastName: $responseDatum['LAST_NAME'],
                        email: $responseDatum['EMAIL_ADDRESS'],
                        salutation: $responseDatum['SALUTATION'],
                        organization: $responseDatum['ORGANISATION_ID'],
                        tags: $responseDatum['TAGS'],
                    )
                );
            }
        }

        return $contacts;
    }

    private function getMethodUrl(string $path): string
    {
        return "{$this->url}/v{$this->version}/$path";
    }
}
