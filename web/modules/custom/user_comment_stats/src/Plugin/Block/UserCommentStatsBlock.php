<?php

namespace Drupal\user_comment_stats\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Proporciona un bloque con estadísticas de comentarios del usuario.
 *
 * @Block(
 *   id = "user_comment_stats_block",
 *   admin_label = @Translation("User Comment Stats Block"),
 *   category = @Translation("Custom")
 * )
 */
class UserCommentStatsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructs a new UserCommentStatsBlock instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
    AccountInterface $current_user,
    RouteMatchInterface $route_match
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_user'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = NULL;

    // Determinar si usamos el usuario de la ruta o el usuario actualmente logueado
    if ($this->routeMatch->getRouteName() === 'entity.user.canonical') {
      $user = $this->routeMatch->getParameter('user');
    }
    else {
      $user = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    }

    // Si el usuario no esta logueado no muestra nada
    if (!$user || $user->isAnonymous()) {
      return [];
    }

    $uid = $user->id();
    $comment_storage = $this->entityTypeManager->getStorage('comment');

    //Total comentarios publicados
    $total_comments = (int) $comment_storage->getQuery()
      ->condition('uid', $uid)
      ->condition('status', 1)
      ->accessCheck(TRUE)
      ->count()
      ->execute();

    //Listado de los últimos 5 comentarios
    $recent_comments_data = [];
    $recent_comment_ids = $comment_storage->getQuery()
      ->condition('uid', $uid)
      ->condition('status', 1)
      ->accessCheck(TRUE)
      ->sort('created', 'DESC')
      ->range(0, 5)
      ->execute();

    if (!empty($recent_comment_ids)) {
      $comments = $comment_storage->loadMultiple($recent_comment_ids);
      foreach ($comments as $comment) {
        $commented_entity = $comment->getCommentedEntity();
        if ($commented_entity) {
          $recent_comments_data[] = [
            'comment_subject' => $comment->getSubject(),
            'comment_url' => $comment->toUrl()->toString(),
            'node_title' => $commented_entity->label(),
            'node_url' => $commented_entity->toUrl()->toString(),
          ];
        }
      }
    }

    //Contador de palabras
    $total_word_count = 0;
    $all_comment_ids = $comment_storage->getQuery()
      ->condition('uid', $uid)
      ->condition('status', 1)
      ->accessCheck(TRUE)
      ->execute();

    if (!empty($all_comment_ids)) {
      $all_comments = $comment_storage->loadMultiple($all_comment_ids);
      foreach ($all_comments as $comment) {
        if ($comment->hasField('comment_body') && !$comment->get('comment_body')->isEmpty()) {
          $body_text = $comment->get('comment_body')->value;
          $total_word_count += str_word_count(strip_tags($body_text));
        }
      }
    }

    //Render array del bloque
    return [
      '#theme' => 'user_comment_stats_block',
      '#total_comments' => $total_comments,
      '#recent_comments' => $recent_comments_data,
      '#total_word_count' => $total_word_count,
      '#user_name' => $user->getDisplayName(),
      '#cache' => [
        'contexts' => ['user', 'url'],
        'tags' => ['user:' . $uid, 'comment_list'],
      ],
        '#attached' => [
         'library' => ['user_comment_stats/styles'],
       ],
    ];
  }

}