import React, { ChangeEvent, FormEvent, useState, useEffect } from 'react';
import axios from 'axios';

type Image = {
  id: number;
  path: string;
};

const ImageUploadForm: React.FC = () => {
  const [image, setImage] = useState<File | null>(null);
  const [images, setImages] = useState<Image[]>([]);

  const handleImageChange = (event: ChangeEvent<HTMLInputElement>) => {
    if (event.target.files && event.target.files[0]) {
      setImage(event.target.files[0]);
    }
  };

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    if (!image) {
      alert('Please select an image to upload.');
      return;
    }

    const formData = new FormData();
    formData.append('image', image);

    try {
      await axios.post('http://localhost:8000/api/upload.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      fetchImages();
    } catch (error) {
      console.error('Error uploading image:', error);
    }
  };

  useEffect(() => {
    fetchImages();
  }, []);

  const fetchImages = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/get_images.php');
      setImages(response.data.images);
    } catch (error) {
      console.error('Error fetching images:', error);
    }
  };

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <input type="file" accept="image/*" onChange={handleImageChange} />
        <button type="submit">Upload Image</button>
      </form>

      <h2>Uploaded Images</h2>
      <div>
        {images.map((image) => (
          <div key={image.id}>
            <img src={`http://localhost:8000/api/uploads/${image.path}`} alt="Uploaded" width="200" />
          </div>
        ))}
      </div>
    </div>
  );
};

export default ImageUploadForm;
