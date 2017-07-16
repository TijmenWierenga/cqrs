<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use PHPUnit\Framework\TestCase;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class HttpExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_a_not_found_exception()
    {
        try {
            throw HttpException::notFound();
        } catch (HttpException $e) {
            $this->assertEquals(404, $e->getStatusCode());
            $this->assertNull($e->getData());
        }
    }

    /**
     * @test
     */
    public function it_throws_a_method_not_allowed_exception()
    {
        try {
            throw HttpException::methodNotAllowed(["POST", "PUT"]);
        } catch (HttpException $e) {
            $this->assertEquals(405, $e->getStatusCode());
            $this->assertArraySubset([
                "allowed_methods" => ["POST", "PUT"]
            ], $e->getData());
        }
    }
}
