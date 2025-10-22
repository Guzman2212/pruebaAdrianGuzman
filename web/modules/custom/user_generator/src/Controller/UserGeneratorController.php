<?php

namespace Drupal\user_generator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\comment\Entity\Comment;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class UserGeneratorController extends ControllerBase {

  /**
   * Genera usuarios aleatorios y les asigna varios comentarios en el /node/1.
   */
  public function generate() {
    $node_id = 1;
    $num_users = 5;
    $comments_per_user = 5;
    $created_users = [];

    for ($i = 1; $i <= $num_users; $i++) {
      // Crear usuario
      $random_name = 'test_user_' . substr(\Drupal::service('uuid')->generate(), 0, 8);
      $email = $random_name . '@example.com';

      $user = User::create([
        'name' => $random_name,
        'mail' => $email,
        'status' => 1,
        'pass' => '123456',
      ]);
      $user->enforceIsNew();
      $user->save();

      // Crear comentarios
      for ($j = 1; $j <= $comments_per_user; $j++) {
        $subject = substr('Comentario ' . $j . ' de ' . $random_name, 0, 60);
        $comment = Comment::create([
          'entity_type' => 'node',
          'entity_id' => $node_id,
          'field_name' => 'comment',
          'uid' => $user->id(),
          'status' => 1,
          'subject' => $subject,
          'comment_body' => [
            'value' => 'Hola, soy ' . $random_name . '. Este es mi comentario automático número ' . $j . '.',
            'format' => 'basic_html',
          ],
        ]);
        $comment->save();
      }

      $created_users[] = $random_name;
    }

    $this->messenger()->addStatus($this->t('@count usuarios fueron creados, cada uno con @comments comentarios.', [
      '@count' => count($created_users),
      '@comments' => $comments_per_user,
    ]));

    $url = Url::fromRoute('entity.node.canonical', ['node' => $node_id])->toString();
    return new RedirectResponse($url);
  }

}

