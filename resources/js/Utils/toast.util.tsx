import { useToast } from "@chakra-ui/react";

/**
 * Custom toast will provied default styles props
 * destructre showToast function
 */
export const useAppToast = () => {
  const toast = useToast();

  const showToast = ({
    title,
    description,
    status,
  }: {
    title: string;
    description: string;
    status: "info" | "warning" | "success" | "error" | "loading" | undefined;
  }) => {
    toast({
      description,
      title,
      status,
      variant: "subtle",
      duration: 9000,
      isClosable: true,
      position: "bottom-left",
    });
  };

  return { showToast };
};
