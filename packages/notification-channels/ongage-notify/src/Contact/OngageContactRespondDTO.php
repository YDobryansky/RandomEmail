<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\OngageNotify\Contact;

use Illuminate\Http\Client\Response;
use NotificationChannels\OngageNotify\Exceptions\CouldNotSendNotification;

class OngageContactRespondDTO implements \JsonSerializable
{
    protected Response $response;

    protected bool $error = false;
    protected int $rows = 0;
    protected int $created = 0;
    /**
     * @var array{string: string}
     */
    protected array $created_emails = [];
    protected int $updated = 0;
    protected array $updated_emails = [];
    protected int $revived = 0;
    protected array $revived_emails = [];
    protected int $success = 0;
    protected int $failed = 0;
    protected array $failed_emails = [];

    /**
     * @throws CouldNotSendNotification
     */
    public function __construct(Response $response)// отримувач
    {
        $this->setResponse($response);

        if ($response->successful()) {
            $this->parseResponse();
        } else {
            $this->errorResponse();
        }
    }

    /**
     * @throws CouldNotSendNotification
     */
    protected function errorResponse()
    {
        throw CouldNotSendNotification::fromResponse($this->getResponse(), static::class);
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return static
     */
    public function setResponse(Response $response): static
    {
        $this->response = $response;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'error' => $this->getError(),
            'rows' => $this->getRows(),
            'created' => $this->getCreated(),
            'created_emails' => $this->getCreatedEmails(),
            'updated' => $this->getUpdated(),
            'updated_emails' => $this->getUpdatedEmails(),
            'revived' => $this->getRevived(),
            'revived_emails' => $this->getRevivedEmails(),
            'success' => $this->getSuccess(),
            'failed' => $this->getFailed(),
            'failed_emails' => $this->getFailedEmails(),
        ];
    }

    protected function parseResponse(): static
    {
        $body = $this->getResponse()->json();

        /**
         * @var array $body = [
         *  "metadata" => [
         *      "error" => false
         *  ],
         *  "payload" => [
         *      "rows" => 2,
         *      "created" => 1,
         *      "created_emails" => [
         *          "some@one.com" => "11111111111111111"
         *      ],
         *      "updated" => 0,
         *      "updated_emails" => [],
         *      "revived" => 0,
         *      "revived_emails" => [],
         *      "success" => 1,
         *      "failed" => 1,
         *      "failed_emails" => [
         *          "john@doe.com" => "Email already exists"
         *      ]
         *  ]
         * ]
         */
        $this->setError($body['metadata']['error']);
        $this->setRows($body['payload']['rows']);
        $this->setCreated($body['payload']['created']);
        $this->setCreatedEmails($body['payload']['created_emails']);
        $this->setUpdated($body['payload']['updated']);
        $this->setUpdatedEmails($body['payload']['updated_emails']);
        $this->setRevived($body['payload']['revived']);
        $this->setRevivedEmails($body['payload']['revived_emails']);
        $this->setSuccess($body['payload']['success']);
        $this->setFailed($body['payload']['failed']);
        $this->setFailedEmails($body['payload']['failed_emails']);

        return $this;
    }

    public function getError(): bool
    {
        return $this->error;
    }

    public function setError(bool $error): static
    {
        $this->error = $error;
        return $this;
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function setRows(int $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    public function setCreated(int $created): static
    {
        $this->created = $created;
        return $this;
    }

    public function getCreatedEmails(): array
    {
        return $this->created_emails;
    }

    public function setCreatedEmails(array $created_emails): static
    {
        $this->created_emails = $created_emails;
        return $this;
    }

    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function setUpdated(int $updated): static
    {
        $this->updated = $updated;
        return $this;
    }

    public function getUpdatedEmails(): array
    {
        return $this->updated_emails;
    }

    public function setUpdatedEmails(array $updated_emails): static
    {
        $this->updated_emails = $updated_emails;
        return $this;
    }

    public function getRevived(): int
    {
        return $this->revived;
    }

    public function setRevived(int $revived): static
    {
        $this->revived = $revived;
        return $this;
    }

    public function getRevivedEmails(): array
    {
        return $this->revived_emails;
    }

    public function setRevivedEmails(array $revived_emails): static
    {
        $this->revived_emails = $revived_emails;
        return $this;
    }

    public function getSuccess(): int
    {
        return $this->success;
    }

    public function setSuccess(int $success): static
    {
        $this->success = $success;
        return $this;
    }

    public function getFailed(): int
    {
        return $this->failed;
    }

    public function setFailed(int $failed): static
    {
        $this->failed = $failed;
        return $this;
    }

    public function getFailedEmails(): array
    {
        return $this->failed_emails;
    }

    public function setFailedEmails(array $failed_emails): static
    {
        $this->failed_emails = $failed_emails;
        return $this;
    }

}
