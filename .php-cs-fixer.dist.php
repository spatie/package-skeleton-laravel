<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()->in([
    'config',
    'database',
    'src',
    'tests',
]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'align_multiline_comment' => [
            'comment_type' => 'phpdocs_like',
        ],
        'array_indentation' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'assign_null_coalescing_to_coalesce_equal' => true,
        'attribute_empty_parentheses' => [
            'use_parentheses' => false,
        ],
        'backtick_to_shell_exec' => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => false,
        'blank_line_before_statement' => [
            'statements' => [
                0 => 'break',
                1 => 'continue',
                2 => 'declare',
                3 => 'return',
                4 => 'throw',
                5 => 'try',
            ],
        ],
        'blank_line_between_import_groups' => false,
        'blank_lines_before_namespace' => true,
        'braces_position' => [
            'allow_single_line_anonymous_functions' => true,
            'allow_single_line_empty_anonymous_classes' => true,
            'anonymous_classes_opening_brace' => 'same_line',
            'anonymous_functions_opening_brace' => 'same_line',
            'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'control_structures_opening_brace' => 'same_line',
            'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
        ],
        'cast_spaces' => [
            'space' => 'single',
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
                'case' => 'none',
            ],
        ],
        'class_definition' => [
            'inline_constructor_arguments' => false,
            'multi_line_extends_each_single_line' => false,
            'single_item_single_line' => false,
            'single_line' => false,
        ],
        'class_reference_name_casing' => true,
        'clean_namespace' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'combine_nested_dirname' => true,
        'comment_to_phpdoc' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'constant_case' => [
            'case' => 'lower',
        ],
        'control_structure_braces' => true,
        'control_structure_continuation_position' => [
            'position' => 'same_line',
        ],
        'date_time_create_from_format_call' => true,
        'date_time_immutable' => true,
        'declare_equal_normalize' => [
            'space' => 'none',
        ],
        'declare_parentheses' => true,
        'declare_strict_types' => true,
        'dir_constant' => true,
        'empty_loop_body' => [
            'style' => 'semicolon',
        ],
        'empty_loop_condition' => [
            'style' => 'while',
        ],
        'ereg_to_preg' => true,
        'escape_implicit_backslashes' => [
            'double_quoted' => true,
            'heredoc_syntax' => true,
            'single_quoted' => true,
        ],
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'fopen_flag_order' => true,
        'fully_qualified_strict_types' => [
            'leading_backslash_in_global_namespace' => true,
        ],
        'function_declaration' => [
            'closure_fn_spacing' => 'one',
            'closure_function_spacing' => 'one',
            'trailing_comma_single_line' => false,
        ],
        'function_to_constant' => [
            'functions' => [
                0 => 'get_called_class',
                1 => 'get_class',
                2 => 'get_class_this',
                3 => 'php_sapi_name',
                4 => 'phpversion',
                5 => 'pi',
            ],
        ],
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                0 => 'author',
                1 => 'class',
                2 => 'namespace',
            ],
            'case_sensitive' => true,
        ],
        'get_class_to_class_keyword' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => true,
        ],
        'heredoc_indentation' => [
            'indentation' => 'same_as_start',
        ],
        'heredoc_to_nowdoc' => true,
        'implode_call' => true,
        'include' => true,
        'integer_literal_case' => true,
        'is_null' => true,
        'lambda_not_used_import' => true,
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'logical_operators' => true,
        'long_to_shorthand_operator' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'mb_str_functions' => true,
        'method_argument_space' => [
            'after_heredoc' => true,
            'attribute_placement' => 'standalone',
            'keep_multiple_spaces_after_comma' => false,
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'method_chaining_indentation' => true,
        'modernize_strpos' => true,
        'modernize_types_casting' => true,
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'native_function_casing' => true,
        'native_function_invocation' => [
            'include' => [
                0 => '@compiler_optimized',
            ],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        'native_type_declaration_casing' => true,
        'new_with_parentheses' => [
            'anonymous_class' => true,
            'named_class' => true,
        ],
        'no_alias_functions' => [
            'sets' => [
                0 => '@all',
            ],
        ],
        'no_alias_language_construct_call' => true,
        'no_alternative_syntax' => true,
        'no_binary_string' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_break_comment' => [
            'comment_text' => 'no break',
        ],
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                0 => 'attribute',
                1 => 'break',
                2 => 'case',
                3 => 'continue',
                4 => 'curly_brace_block',
                5 => 'default',
                6 => 'extra',
                7 => 'parenthesis_brace_block',
                8 => 'return',
                9 => 'square_brace_block',
                10 => 'switch',
                11 => 'throw',
                12 => 'use',
                13 => 'use_trait',
            ],
        ],
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_multiple_statements_per_line' => true,
        'no_php4_constructor' => true,
        'no_short_bool_cast' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_around_offset' => true,
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'allow_unused_params' => false,
            'remove_inheritdoc' => false,
        ],
        'no_trailing_comma_in_singleline' => [
            'elements' => [
                0 => 'arguments',
                1 => 'array',
                2 => 'array_destructuring',
                3 => 'group_import',
            ],
        ],
        'no_unneeded_braces' => [
            'namespaces' => false,
        ],
        'no_unneeded_control_parentheses' => [
            'statements' => [
                0 => 'break',
                1 => 'clone',
                2 => 'continue',
                3 => 'echo_print',
                4 => 'negative_instanceof',
                5 => 'others',
                6 => 'return',
                7 => 'switch_case',
                8 => 'yield',
                9 => 'yield_from',
            ],
        ],
        'no_unneeded_final_method' => [
            'private_methods' => true,
        ],
        'no_unneeded_import_alias' => true,
        'no_unreachable_default_argument_value' => true,
        'no_unset_cast' => true,
        'no_unused_imports' => true,
        'no_useless_concat_operator' => true,
        'no_useless_else' => true,
        'no_useless_nullsafe_operator' => true,
        'no_useless_return' => true,
        'no_useless_sprintf' => true,
        'no_whitespace_before_comma_in_array' => [
            'after_heredoc' => true,
        ],
        'non_printable_character' => [
            'use_escape_sequences_in_strings' => true,
        ],
        'normalize_index_brace' => true,
        'nullable_type_declaration' => [
            'syntax' => 'question_mark',
        ],
        'nullable_type_declaration_for_default_null_value' => [
            'use_nullable_type_declaration' => true,
        ],
        'object_operator_without_whitespace' => true,
        'octal_notation' => true,
        'operator_linebreak' => [
            'only_booleans' => true,
            'position' => 'beginning',
        ],
        'ordered_class_elements' => [
            'case_sensitive' => false,
            'order' => [
                0 => 'use_trait',
                1 => 'constant',
                2 => 'property_static',
                3 => 'property',
                4 => 'case',
                5 => 'construct',
            ],
            'sort_algorithm' => 'none',
        ],
        'ordered_imports' => [
            'case_sensitive' => false,
            'imports_order' => [
                0 => 'class',
                1 => 'function',
                2 => 'const',
            ],
            'sort_algorithm' => 'alpha',
        ],
        'ordered_interfaces' => [
            'case_sensitive' => false,
            'direction' => 'ascend',
            'order' => 'alpha',
        ],
        'ordered_traits' => [
            'case_sensitive' => false,
        ],
        'ordered_types' => [
            'case_sensitive' => false,
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'php_unit_construct' => true,
        'php_unit_data_provider_return_type' => true,
        'php_unit_data_provider_static' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_dedicate_assert_internal_type' => true,
        'php_unit_expectation' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_method_casing' => [
            'case' => 'camel_case',
        ],
        'php_unit_mock' => true,
        'php_unit_mock_short_will_return' => true,
        'php_unit_namespaced' => true,
        'php_unit_no_expectation_annotation' => true,
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_test_annotation' => [
            'style' => 'annotation',
        ],
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this',
        ],
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => true,
        ],
        'phpdoc_align' => [
            'align' => 'left',
            'tags' => [
                0 => 'method',
                1 => 'param',
                2 => 'property',
                3 => 'property-read',
                4 => 'property-write',
                5 => 'return',
                6 => 'throws',
                7 => 'type',
                8 => 'var',
            ],
        ],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => [
            'tags' => [
                0 => 'example',
                1 => 'id',
                2 => 'internal',
                3 => 'inheritdoc',
                4 => 'inheritdocs',
                5 => 'link',
                6 => 'source',
                7 => 'toc',
                8 => 'tutorial',
            ],
        ],
        'phpdoc_line_span' => [
            'const' => 'single',
            'method' => 'multi',
            'property' => 'single',
        ],
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => [
            'replacements' => [
                'inheritDoc' => 'inheritdoc',
                'type' => 'var',
                'link' => 'see',
            ],
        ],
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => [
            'order' => [
                0 => 'param',
                1 => 'return',
                2 => 'throws',
                3 => 'inheritdoc',
                4 => 'phpcsSuppress',
            ],
        ],
        'phpdoc_order_by_value' => [
            'annotations' => [
                0 => 'covers',
                1 => 'throws',
            ],
        ],
        'phpdoc_param_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types' => [
            'groups' => [
                0 => 'alias',
                1 => 'meta',
                2 => 'simple',
            ],
        ],
        'phpdoc_types_order' => [
            'case_sensitive' => false,
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,
        'pow_to_exponentiation' => true,
        'psr_autoloading' => true,
        'random_api_migration' => true,
        'regular_callable_call' => true,
        'return_assignment' => true,
        'return_type_declaration' => [
            'space_before' => 'none',
        ],
        'self_accessor' => true,
        'self_static_accessor' => true,
        'semicolon_after_instruction' => true,
        'set_type_to_cast' => true,
        'simple_to_complex_string_variable' => true,
        'simplified_null_return' => true,
        'single_class_element_per_statement' => [
            'elements' => [
                0 => 'const',
                1 => 'property',
            ],
        ],
        'single_import_per_statement' => [
            'group_to_single_imports' => true,
        ],
        'single_line_comment_spacing' => true,
        'single_line_comment_style' => [
            'comment_types' => [
                0 => 'hash',
            ],
        ],
        'single_line_empty_body' => true,
        'single_quote' => [
            'strings_containing_single_quote_chars' => false,
        ],
        'single_space_around_construct' => true,
        'space_after_semicolon' => [
            'remove_in_empty_for_expressions' => true,
        ],
        'spaces_inside_parentheses' => [
            'space' => 'none',
        ],
        'standardize_not_equals' => true,
        'statement_indentation' => true,
        'strict_param' => true,
        'string_length_to_empty' => true,
        'switch_continue_to_break' => true,
        'ternary_to_elvis_operator' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => [
                0 => 'arrays',
                1 => 'match',
                2 => 'parameters',
            ],
        ],
        'trim_array_spaces' => true,
        'type_declaration_spaces' => true,
        'types_spaces' => [
            'space' => 'none',
            'space_multiple_catch' => 'none',
        ],
        'unary_operator_spaces' => true,
        'visibility_required' => [
            'elements' => [
                0 => 'const',
                1 => 'method',
                2 => 'property',
            ],
        ],
        'void_return' => true,
        'whitespace_after_comma_in_array' => [
            'ensure_single_space' => true,
        ],
        'yoda_style' => [
            'always_move_variable' => false,
            'equal' => false,
            'identical' => null,
            'less_and_greater' => null,
        ],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
